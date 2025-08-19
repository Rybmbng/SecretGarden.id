<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\EmailSettingModel;
use CodeIgniter\Controller;

class EmailConfigController extends BaseController
{
    protected $emailModel;

    public function __construct()
    {
        $this->emailModel = new EmailSettingModel();
    }

    public function index()
    {
        $data['config'] = $this->emailModel->orderBy('id','DESC')->first();
        return view('admin/setting/email/index', $data);
    }

    public function update()
    {
        $post = $this->request->getPost();
        $this->emailModel->save([
            'id' => 1, 
            'smtp_host' => $post['smtp_host'],
            'smtp_user' => $post['smtp_user'],
            'smtp_pass' => $post['smtp_pass'],
            'smtp_port' => $post['smtp_port'],
            'smtp_crypto' => $post['smtp_crypto'],
            'from_email' => $post['from_email'],
            'to_email' => $post['to_email'],
        ]);

        return redirect()->back()->with('success','Email configuration updated.');
    }
}