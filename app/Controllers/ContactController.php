<?php

namespace App\Controllers;
use App\Controllers\BaseController;
use App\Models\EmailConfigModel;
use App\Models\ContactMessageModel;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ContactController extends BaseController
{
    protected $emailModel;
    protected $messageModel;

    public function __construct()
    {
        $this->emailModel = new EmailConfigModel();
        $this->messageModel = new ContactMessageModel();
    }

    public function index()
    {
        return view('service/cu/index');
    }

    public function send()
    {
        $name        = $this->request->getPost('name');        
        $userEmail   = $this->request->getPost('email'); 
        $messageText = $this->request->getPost('message');

        $cfg = $this->emailModel->orderBy('id','DESC')->first();
        if (!$cfg) {
            return redirect()->back()->with('error', '❌ Email configuration not found.');
        }

        $fromEmail = $cfg['smtp_user'];
        $toEmail   = $cfg['smtp_user']; 
        $mail = new PHPMailer(true);

        try {
            $mail->isSMTP();
            $mail->Host       = $cfg['smtp_host'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $cfg['smtp_user'];
            $mail->Password   = $cfg['smtp_pass'];
            $mail->Port       = (int)$cfg['smtp_port'];

            $mail->SMTPSecure = ($cfg['smtp_port'] == 465) ? PHPMailer::ENCRYPTION_SMTPS : PHPMailer::ENCRYPTION_STARTTLS;

            $mail->SMTPOptions = [
                'ssl' => [
                    'verify_peer'       => false,
                    'verify_peer_name'  => false,
                    'allow_self_signed' => true,
                ],
            ];

            // Set From, To, Reply-To
            $mail->setFrom($fromEmail, $cfg['name']."ContactUS"); 
            $mail->addAddress($toEmail);                 
            $mail->addReplyTo($userEmail, $name);       

            $mail->isHTML(true);
            $mail->Subject = "Contact Us Message from $userEmail($name)";
            $mail->Body    = nl2br($messageText);

            $mail->send();

            // Simpan pesan ke database
            $this->messageModel->save([
                'name'    => $name,
                'email'   => $userEmail,
                'message' => $messageText
            ]);

            return redirect()->back()->with('success','✅ Message sent successfully!');
        } catch (Exception $e) {
            return redirect()->back()->with('error','❌ Failed to send message: '.$mail->ErrorInfo);
        }
    }
}
