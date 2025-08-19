<?php

namespace App\Controllers;
use CodeIgniter\Controller;
use App\Models\EmailSettingModel;
use App\Models\ContactMessageModel;

class ContactController extends BaseController
{
    protected $emailModel;
    protected $messageModel;

    public function __construct()
    {
        $this->emailModel = new EmailSettingModel();
        $this->messageModel = new ContactMessageModel();
    }

    public function index()
    {
        return view('service/cu/index');
    }

    public function send()
    {
        $name = $this->request->getPost('name');        
        $userEmail = $this->request->getPost('email'); 
        $messageText = $this->request->getPost('message');

        $cfg = $this->emailModel->orderBy('id','DESC')->first();
        // echo print_r($cfg);
        // die();
        $email = \Config\Services::email();
        $email->initialize([
            'protocol' => 'smtp',
            'SMTPHost' => $cfg['smtp_host'],
            'SMTPUser' => $cfg['smtp_user'],
            'SMTPPass' => $cfg['smtp_pass'],
            'SMTPPort' => $cfg['smtp_port'],
            'SMTPCrypto' => $cfg['smtp_crypto'],
            'mailType' => 'html',
        ]);


        $email->setFrom($cfg['from_email'], $name); 
        $email->setTo($cfg['to_email']);          
        $email->setReplyTo($userEmail, $name);     
        $email->setSubject("Contact Us Message from $name");
        $email->setMessage($messageText);
        echo print_r($cfg);
        // die();
        if($email->send()){
            $this->messageModel->save([
                'name' => $name,
                'email' => $userEmail,
                'message' => $messageText
            ]);
            return redirect()->back()->with('success','Message sent successfully!');
        } else {
            $debug = $email->printDebugger(['headers']);
            // return redirect()->back()->with('error','Failed to send message: '.implode(", ", $debug));
        }
    }
}