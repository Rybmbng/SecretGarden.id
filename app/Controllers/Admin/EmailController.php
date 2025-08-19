<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\EmailModel;
use App\Models\EmailConfigModel;

class EmailController extends BaseController
{
    protected $emailModel;
    protected $configModel;

    public function __construct()
    {
        $this->emailModel = new EmailModel();
        $this->configModel = new EmailConfigModel();
    }

    public function index($folder = 'inbox')
    {
        $request = service('request');
        $search = $request->getGet('search') ?? '';
        $filter = $request->getGet('filter') ?? 'all';
        $perPage = 12;

        $query = $this->emailModel->where('folder', $folder);

        if ($search) {
            $query = $query->groupStart()->like('subject', $search)->orLike('sender_email', $search)->orLike('sender_name', $search)->groupEnd();
        }

        if ($filter === 'unread') {
            $query = $query->where('is_new', 1);
        } elseif ($filter === 'replied') {
            $query = $query->where('replied', 1);
        }

        $emails = $query->orderBy('received_at', 'DESC')->paginate($perPage, 'emails');
        $pager  = $this->emailModel->pager;
        $counts = [
            'inbox' => $this->emailModel->where('folder','inbox')->where('is_new',1)->countAllResults(),
            'sent'  => $this->emailModel->where('folder','sent')->countAllResults(),
            'drafts'=> $this->emailModel->where('folder','draft')->countAllResults(),
            'trash' => $this->emailModel->where('folder','trash')->countAllResults(),
        ];

        return view('admin/emails/index', [
            'emails' => $emails,
            'pager' => $pager,
            'search' => $search,
            'filter' => $filter,
            'folder' => $folder,
            'counts' => $counts
        ]);
    }

    public function fetch()
    {
        $config = $this->configModel->first();
        if (!$config) {
            return redirect()->back()->with('error','Email config not set.');
        }

        $host = $config['imap_host'] ?? '';
        $port = (int)($config['imap_port'] ?? 993);
        $user = $config['imap_user'] ?? '';
        $pass = $config['imap_pass'] ?? '';

        if (!$host || !$user) return redirect()->back()->with('error','IMAP credentials incomplete.');

        $mailbox = '{'.$host.':'.$port.'/imap/ssl}INBOX';
        $inbox = @imap_open($mailbox, $user, $pass);
        if (!$inbox) return redirect()->back()->with('error','Failed to connect IMAP: '.imap_last_error());

        $msgs = imap_search($inbox, 'UNSEEN');
        $new = 0;
        if ($msgs) {
            foreach ($msgs as $num) {
                $ov = imap_fetch_overview($inbox, $num, 0)[0];
                $body = imap_fetchbody($inbox, $num, 1);
                if (!$body) $body = imap_fetchbody($inbox, $num, "1.1");
                $fromRaw = $ov->from ?? '';
                $parsed = imap_rfc822_parse_adrlist($fromRaw, 'domain.tld');
                $senderEmail = $fromRaw;
                $senderName = $fromRaw;
                if ($parsed && isset($parsed[0])) {
                    $senderEmail = $parsed[0]->mailbox . '@' . $parsed[0]->host;
                    $senderName = isset($parsed[0]->personal) ? imap_utf8($parsed[0]->personal) : $senderEmail;
                }
                $this->emailModel->insert([
                    'sender_email' => $senderEmail,
                    'sender_name'  => $senderName,
                    'subject'      => imap_utf8($ov->subject ?? '(no subject)'),
                    'body'         => quoted_printable_decode($body),
                    'received_at'  => date('Y-m-d H:i:s', strtotime($ov->date ?? 'now')),
                    'folder'       => 'inbox',
                    'is_new'       => 1,
                ]);
                $new++;
            }
        }
        imap_close($inbox);
        return redirect()->back()->with('success', "Fetched {$new} new email(s).");
    }

    // View single email with thread (children)
    public function view($id)
    {
        $email = $this->emailModel->find($id);
        if (!$email) return redirect()->back()->with('error','Email not found.');

        if ($email['is_new']) $this->emailModel->update($id, ['is_new' => 0]);

        $thread = $this->emailModel->where('parent_id', $id)->orderBy('id','ASC')->findAll();
        return view('admin/emails/view', ['email'=>$email, 'thread'=>$thread]);
    }

    // Compose & save draft or send
    public function compose()
    {
        $request = service('request');
        if ($request->getMethod() === 'post') {
            $to = $request->getPost('to');
            $subject = $request->getPost('subject');
            $message = $request->getPost('message');
            $saveDraft = $request->getPost('save_draft');

            if ($saveDraft) {
                // save to drafts
                $this->emailModel->insert([
                    'sender_email' => $this->configModel->first()['smtp_user'] ?? '',
                    'sender_name'  => 'Admin',
                    'subject'      => $subject,
                    'body'         => $message,
                    'received_at'  => date('Y-m-d H:i:s'),
                    'folder'       => 'draft',
                    'is_new'       => 0,
                ]);
                return redirect()->to('/admin/email/draft')->with('success','Draft saved.');
            } else {
                // send using SMTP
                $config = $this->configModel->first();
                $emailService = \Config\Services::email();
                $emailService->initialize([
                    'protocol' => 'smtp',
                    'SMTPHost' => $config['smtp_host'],
                    'SMTPUser' => $config['smtp_user'],
                    'SMTPPass' => $config['smtp_pass'],
                    'SMTPPort' => $config['smtp_port'],
                    'SMTPCrypto' => ($config['smtp_port']==465)?'ssl':'tls',
                    'mailType' => $config['mail_type'] ?? 'html',
                    'charset' => 'UTF-8',
                ]);

                $emailService->setFrom($config['smtp_user'], 'Admin');
                $emailService->setTo($to);
                $emailService->setSubject($subject);
                $emailService->setMessage($message);

                if ($emailService->send()) {
                    // insert into sent folder
                    $this->emailModel->insert([
                        'sender_email' => $config['smtp_user'],
                        'sender_name'  => 'Admin',
                        'subject'      => $subject,
                        'body'         => $message,
                        'received_at'  => date('Y-m-d H:i:s'),
                        'folder'       => 'sent',
                        'is_new'       => 0,
                    ]);
                    return redirect()->to('/admin/email/sent')->with('success','Email sent.');
                } else {
                    $dbg = $emailService->printDebugger(['headers']);
                    return redirect()->back()->with('error','Failed to send: '.$dbg);
                }
            }
        }
        return view('admin/emails/compose');
    }

    // Reply (threaded) to email id
    public function reply($id)
    {
        $email = $this->emailModel->find($id);
        if (!$email) return redirect()->back()->with('error','Email not found.');

        $request = service('request');
        if ($request->getMethod() === 'post') {
            $message = $request->getPost('message');

            $config = $this->configModel->first();
            $emailService = \Config\Services::email();
            $emailService->initialize([
                'protocol' => 'smtp',
                'SMTPHost' => $config['smtp_host'],
                'SMTPUser' => $config['smtp_user'],
                'SMTPPass' => $config['smtp_pass'],
                'SMTPPort' => $config['smtp_port'],
                'SMTPCrypto' => ($config['smtp_port']==465)?'ssl':'tls',
                'mailType' => $config['mail_type'] ?? 'html',
                'charset' => 'UTF-8',
            ]);

            $emailService->setFrom($config['smtp_user'], 'Admin');
            $emailService->setTo($email['sender_email']);
            $emailService->setSubject('Re: '.$email['subject']);
            $html = view('admin/emails/template_reply', [
                'name' => $email['sender_name'],
                'original' => $email['body'],
                'reply' => $message
            ]);
            $emailService->setMessage($html);

            if ($emailService->send()) {
                $this->emailModel->insert([
                    'sender_email' => $config['smtp_user'],
                    'sender_name'  => 'Admin',
                    'subject'      => 'Re: '.$email['subject'],
                    'body'         => $message,
                    'received_at'  => date('Y-m-d H:i:s'),
                    'folder'       => 'sent',
                    'parent_id'    => $id,
                    'is_new'       => 0,
                    'replied'      => 1,
                ]);
                $this->emailModel->update($id, ['replied' => 1]);
                return redirect()->to('/admin/email/view/'.$id)->with('success','Reply sent.');
            } else {
                return redirect()->back()->with('error','Failed to send reply.');
            }
        }
        return view('admin/emails/reply', ['email'=>$email]);
    }

    // Move to trash
    public function trash($id)
    {
        $this->emailModel->update($id, ['folder' => 'trash']);
        return redirect()->back()->with('success','Moved to Trash.');
    }

    // Restore from trash to inbox
    public function restore($id)
    {
        $this->emailModel->update($id, ['folder' => 'inbox']);
        return redirect()->back()->with('success','Restored.');
    }

    // Permanent delete
    public function delete($id)
    {
        $this->emailModel->delete($id);
        return redirect()->back()->with('success','Permanently deleted.');
    }

    // AJAX polling endpoint for counts
    public function counts()
    {
        $counts = [
            'inbox' => $this->emailModel->where('folder','inbox')->where('is_new',1)->countAllResults(),
            'total_inbox' => $this->emailModel->where('folder','inbox')->countAllResults(),
        ];
        return $this->response->setJSON($counts);
    }
}
