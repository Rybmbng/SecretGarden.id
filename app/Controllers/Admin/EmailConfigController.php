<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\EmailConfigModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class EmailConfigController extends BaseController
{
    protected $configModel;

    public function __construct()
    {
        $this->configModel = new EmailConfigModel();
    }

    public function index()
    {
        $config = $this->configModel->getConfig();
        return view('admin/setting/email/index', ['config' => $config]);
    }

    public function save()
    {
        $data = $this->request->getPost([
            'smtp_host','smtp_user','smtp_pass','smtp_port',
            'imap_host','imap_user','imap_pass','imap_port','mail_type','name'
        ]);

        $existing = $this->configModel->getConfig();
        if ($existing) {
            $this->configModel->update($existing['id'], $data);
        } else {
            $this->configModel->insert($data);
        }

        return redirect()->to('/admin/setting/email')->with('success','Config saved.');
    }

    // 🔧 Test connection (SMTP / IMAP)
    public function testConnection()
    {
        $request  = service('request');
        $testType = $request->getPost('test_type');

        try {
            switch ($testType) {
                case 'smtp-connection':
                    return $this->testSmtpConnection($request);

                case 'smtp':
                    return $this->testSmtpSend($request);

                case 'imap':
                    return $this->testImap($request);

                default:
                    return $this->response->setJSON([
                        'status'  => 'error',
                        'message' => "❌ Jenis test tidak dikenal."
                    ]);
            }
        } catch (\Throwable $e) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => "❌ Error: " . $e->getMessage()
            ]);
        }
    }

    private function testImap($request)
    {
        $host = $request->getPost('imap_host');
        $port = (int) $request->getPost('imap_port');
        $user = $request->getPost('imap_user');
        $pass = $request->getPost('imap_pass');

        $mailbox = "{" . $host . ":" . $port . "/imap/ssl/novalidate-cert}INBOX";
        $connection = @imap_open($mailbox, $user, $pass);

        if ($connection) {
            imap_close($connection);
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => "✅ IMAP Connection berhasil ke $host:$port"
            ]);
        } else {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => "❌ IMAP gagal: " . imap_last_error()
            ]);
        }
    }

    private function testSmtpConnection($request)
    {
        $host = $request->getPost('smtp_host');
        $port = (int) $request->getPost('smtp_port') ?: 587;

        $errorMsg = null;
        set_error_handler(function($errno, $errstr) use (&$errorMsg) {
            $errorMsg = $errstr;
            return true;
        });

        $conn = @fsockopen($host, $port, $errno, $errstr, 10);
        restore_error_handler();

        if (is_resource($conn)) {
            fclose($conn);
            return $this->response->setJSON([
                'status' => 'success',
                'message'=> "✅ Berhasil connect ke {$host}:{$port}"
            ]);
        }

        return $this->response->setJSON([
            'status' => 'error',
            'message'=> "❌ Gagal connect ke {$host}:{$port}. Error: " . ($errorMsg ?? $errstr)
        ]);
    }

    private function testSmtpSend($request)
    {
        $name     = $request->getPost('name');
        $host     = $request->getPost('smtp_host');
        $port     = (int) $request->getPost('smtp_port');
        $user     = $request->getPost('smtp_user');
        $pass     = $request->getPost('smtp_pass');
        $to       = $request->getPost('to'); // email tujuan test
        $subject  = 'Test Email';
        $message  = 'Ini email percobaan dari SecretGarden.id';

        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = $host;
            $mail->SMTPAuth   = true;
            $mail->Username   = $user;
            $mail->Password   = $pass;
            $mail->Port       = $port;

            $mail->SMTPSecure = ($port === 465) ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;

            // bypass self-signed certificate
            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true,
                ],
            ];

            $mail->setFrom($user, $name);
            $mail->addAddress($to);
            $mail->Subject = $subject;
            $mail->Body    = $message;
            $mail->isHTML(true);

            $mail->send();

            return $this->response->setJSON([
                'status'  => 'success',
                'message' => "✅ Test email berhasil dikirim ke $to"
            ]);

        } catch (Exception $e) {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => "❌ Gagal kirim email: " . $mail->ErrorInfo
            ]);
        }
    }
}
