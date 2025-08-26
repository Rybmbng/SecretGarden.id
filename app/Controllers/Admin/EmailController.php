<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\EmailConfigModel;
use App\Models\EmailModel;
use App\Models\EmailAttachmentModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailController extends BaseController
{
    protected $configModel;
    protected $emailModel;
    protected $attachModel;

    public function __construct()
    {
        $this->configModel = new EmailConfigModel();
        $this->emailModel  = new EmailModel();
        $this->attachModel = new EmailAttachmentModel();
    }

    public function sync()
    {
        $config = $this->configModel->getConfig();

        $mailbox = "{" . $config['imap_host'] . ":" . $config['imap_port'] . "/imap/ssl/novalidate-cert}INBOX";
        $inbox   = @imap_open($mailbox, $config['imap_user'], $config['imap_pass']);

        if (!$inbox) {
            return redirect()->back()->with('error', 'Gagal koneksi IMAP: ' . imap_last_error());
        }

        $emails = imap_search($inbox, 'ALL', SE_UID);

        if ($emails && count($emails) > 0) {
            foreach ($emails as $uid) {
                $msgno = imap_msgno($inbox, $uid);
                if ($msgno <= 0) continue;

                $overview = imap_fetch_overview($inbox, $msgno, 0);
                $header   = imap_headerinfo($inbox, $msgno);

                $body = imap_fetchbody($inbox, $msgno, 1.1);
                if (empty($body)) {
                    $body = imap_fetchbody($inbox, $msgno, 1);
                }

                if (!$this->emailModel->where('uid', $uid)->first()) {
                    $id = $this->emailModel->insert([
                        'uid'        => $uid,
                        'subject'    => imap_utf8($overview[0]->subject ?? ''),
                        'from_email' => isset($header->from[0]) ? $header->from[0]->mailbox . '@' . $header->from[0]->host : null,
                        'to_email'   => isset($header->to[0]) ? $header->to[0]->mailbox . '@' . $header->to[0]->host : null,
                        'body'       => quoted_printable_decode($body),
                        'date'       => date("Y-m-d H:i:s", strtotime($overview[0]->date ?? 'now')),
                        'is_seen'    => ($overview[0]->seen ?? 0) ? 1 : 0,
                        'folder'     => 'INBOX',
                        'direction'  => 'in'
                    ]);

                    // 📎 Attachment
                    $structure = imap_fetchstructure($inbox, $msgno);
                    if (isset($structure->parts) && count($structure->parts)) {
                        foreach ($structure->parts as $i => $part) {
                            $filename = null;

                            if ($part->ifdparameters) {
                                foreach ($part->dparameters as $obj) {
                                    if (strtolower($obj->attribute) === 'filename') $filename = $obj->value;
                                }
                            }
                            if (!$filename && $part->ifparameters) {
                                foreach ($part->parameters as $obj) {
                                    if (strtolower($obj->attribute) === 'name') $filename = $obj->value;
                                }
                            }

                            if ($filename) {
                                $attachment = imap_fetchbody($inbox, $msgno, $i+1);
                                if ($part->encoding == 3) $attachment = base64_decode($attachment);
                                elseif ($part->encoding == 4) $attachment = quoted_printable_decode($attachment);

                                $uploadPath = WRITEPATH . 'uploads/email/';
                                if (!is_dir($uploadPath)) mkdir($uploadPath, 0777, true);

                                $path = $uploadPath . $filename;
                                file_put_contents($path, $attachment);

                                $this->attachModel->insert([
                                    'email_id'  => $id,
                                    'file_name' => $filename,
                                    'file_path' => $path,
                                    'mime_type' => $part->subtype ?? 'application/octet-stream'
                                ]);
                            }
                        }
                    }
                }
            }
        }

        imap_close($inbox);
        return redirect()->to('/admin/email/inbox')->with('success', 'Sync selesai ✅');
    }

    public function inbox()
    {
        $emails = $this->emailModel->orderBy('date','DESC')->findAll();
        return view('admin/email/inbox', ['emails' => $emails]);
    }

    public function compose()
    {
        return view('admin/email/compose');
    }

    public function send()
    {
        $config = $this->configModel->getConfig();
        $mail   = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = $config['smtp_host'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $config['smtp_user'];
            $mail->Password   = $config['smtp_pass'];
            $port             = (int) $config['smtp_port'];
            $mail->Port       = $port;

            if ($port === 465) $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            else $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true,
                ],
            ];

            $mail->setFrom($config['smtp_user'], $config['name']);
            $mail->addAddress($this->request->getPost('to'));
            $mail->Subject = $this->request->getPost('subject');
            $mail->Body    = $this->request->getPost('message');
            $mail->isHTML(true);

            $mail->send();
            return redirect()->back()->with('success', '✅ Email berhasil dikirim');

        } catch (Exception $e) {
            return redirect()->back()->with('error', '❌ Email gagal dikirim: ' . $mail->ErrorInfo);
        }
    }

    public function view($id)
    {
        $email = $this->emailModel->find($id);
        if (!$email) return redirect()->to('/admin/email/inbox')->with('error', 'Email tidak ditemukan.');

        $attachments = $this->attachModel->where('email_id', $id)->findAll();

        return view('admin/email/view', [
            'email'       => $email,
            'attachments' => $attachments
        ]);
    }


    public function reply($id)
    {
        $emailData = $this->emailModel->find($id);
        return view('admin/email/reply', ['email' => $emailData]);
    }

    public function sendReply($id)
    {
        $mail   = $this->emailModel->find($id);
        if (!$mail) return redirect()->back()->with('error','Email tidak ditemukan.');

        $config = $this->configModel->getConfig();
        $body   = $this->request->getPost('body');
        $subject= "Re: " . $mail['subject'];

        $email = new PHPMailer(true);
        try {
            $email->isSMTP();
            $email->Host       = $config['smtp_host'];
            $email->SMTPAuth   = true;
            $email->Username   = $config['smtp_user'];
            $email->Password   = $config['smtp_pass'];
            $port             = (int) $config['smtp_port'];
            $email->Port       = $port;

            if ($port === 465) $email->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            else $email->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

            $email->SMTPOptions = [
                'ssl' => [
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true,
                ],
            ];

            $email->setFrom($config['smtp_user'], $config['name']);
            $email->addAddress($mail['from_email']);
            $email->Subject = $subject;
            $email->Body    = $body;
            $email->isHTML(true);
            $email->send();

            $this->emailModel->insert([
                'uid'        => uniqid(),
                'subject'    => $subject,
                'from_email' => $config['smtp_user'],
                'to_email'   => $mail['from_email'],
                'body'       => $body,
                'folder'     => 'Sent',
                'direction'  => 'out',
                'is_seen'    => 1,
                'date'       => date('Y-m-d H:i:s')
            ]);

            return redirect()->to('/admin/email/inbox')->with('success','Balasan terkirim ✅');
        } catch (Exception $e) {
            return redirect()->back()->with('error','Gagal kirim balasan: '.$email->ErrorInfo);
        }
    }

    public function download($id)
    {
        $attachment = $this->attachModel->find($id);
        if (!$attachment) {
            return redirect()->back()->with('error', 'File Not Found.');
        }
        $filePath = WRITEPATH . 'writable/uploads/email/' . $attachment['file_name'];
        $fileName = $attachment['original_name'] ?? $attachment['file_name'];
        if (!is_file($filePath)) {
            return redirect()->back()->with('error', 'File Not Found');
        }
        return $this->response->download($filePath, null)->setFileName($fileName);
    }

    public function forward($id)
    {
        $emailData = $this->emailModel->find($id);
        return view('admin/email/forward', ['email' => $emailData]);
    }

    public function sendForward($id)
    {
        $mail = $this->emailModel->find($id);
        if (!$mail) return redirect()->back()->with('error','Email tidak ditemukan.');

        $config  = $this->configModel->getConfig();
        $to      = $this->request->getPost('to');
        $subject = "Fwd: " . $mail['subject'];
        $body    = $this->request->getPost('body') . "\n\n---- Forwarded Message ----\n" . $mail['body'];

        $email = new PHPMailer(true);
        try {
            $email->isSMTP();
            $email->Host       = $config['smtp_host'];
            $email->SMTPAuth   = true;
            $email->Username   = $config['smtp_user'];
            $email->Password   = $config['smtp_pass'];
            $port             = (int) $config['smtp_port'];
            $email->Port       = $port;

            if ($port === 465) $email->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
            else $email->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

            $email->SMTPOptions = [
                'ssl' => [
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true,
                ],
            ];

            $email->setFrom($config['smtp_user'], $config['name']);
            $email->addAddress($to);
            $email->Subject = $subject;
            $email->Body    = $body;
            $email->isHTML(true);
            $email->send();

            $this->emailModel->insert([
                'uid'        => uniqid(),
                'subject'    => $subject,
                'from_email' => $config['smtp_user'],
                'to_email'   => $to,
                'body'       => $body,
                'folder'     => 'Sent',
                'direction'  => 'out',
                'is_seen'    => 1,
                'date'       => date('Y-m-d H:i:s')
            ]);

            return redirect()->to('/admin/email/inbox')->with('success','Email berhasil diteruskan ✅');
        } catch (Exception $e) {
            return redirect()->back()->with('error','Gagal forward email: '.$email->ErrorInfo);
        }
    }
}
