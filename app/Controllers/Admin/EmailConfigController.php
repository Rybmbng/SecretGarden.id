<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\EmailConfigModel;

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
        return view('admin/emails/config', ['config' => $config]);
    }

    public function save()
    {
        $data = $this->request->getPost([
            'smtp_host','smtp_user','smtp_pass','smtp_port',
            'imap_host','imap_user','imap_pass','imap_port','mail_type'
        ]);
        $existing = $this->configModel->getConfig();
        if ($existing) {
            $this->configModel->update($existing['id'], $data);
        } else {
            $this->configModel->insert($data);
        }
        return redirect()->to('/admin/setting/email')->with('success','Config saved.');
    }
public function testConnection()
{
    $request = service('request');

    $host     = $request->getPost('imap_host');
    $port     = $request->getPost('imap_port');
    $username = $request->getPost('imap_user');
    $password = $request->getPost('imap_pass');

    try {
        $imap = @imap_open("{" . $host . ":" . $port . "/imap/ssl}INBOX", $username, $password);

        if ($imap) {
            imap_close($imap);
            return $this->response->setJSON([
                'status'  => 'success',
                'message' => 'Koneksi IMAP berhasil.'
            ]);
        } else {
            return $this->response->setJSON([
                'status'  => 'error',
                'message' => 'Koneksi IMAP gagal: ' . imap_last_error()
            ]);
        }
    } catch (\Exception $e) {
        return $this->response->setJSON([
            'status'  => 'error',
            'message' => 'Error: ' . $e->getMessage()
        ]);
    }
}



}
