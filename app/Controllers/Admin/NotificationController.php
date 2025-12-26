<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\NotificationSettingModel;

class NotificationController extends BaseController
{
    protected $notifModel;
    protected $modelOptions = [
        'Produk' => 'Product',
        'Variant' => 'ProductVariant',
    ];

    protected $fieldOptions = [
        'Product' => ['name', 'created_at', 'updated_at'],
        'ProductVariant' => ['name', 'stock', 'created_at', 'updated_at'],
    ];

    public function __construct()
    {
        $this->notifModel = new NotificationSettingModel();
    }

    public function index()
    {
        $data['settings'] = $this->notifModel->orderBy('id','DESC')->findAll();
        $data['modelOptions'] = $this->modelOptions;
        $data['fieldOptions'] = $this->fieldOptions;
        $data['pageTitle'] = "Notification Management";
        return view('admin/setting/notification/index', $data);
    }

    public function store()
    {
        $soundFile = $this->request->getFile('sound_file');
        $soundPath = null;
        if ($soundFile && $soundFile->isValid() && !$soundFile->hasMoved()) {
            $newName = $soundFile->getRandomName();
            $soundFile->move(ROOTPATH.'public/assets/sounds/', $newName);
            $soundPath = 'assets/sounds/'.$newName;
        }

        $this->notifModel->insert([
            'type' => $this->request->getPost('type'),
            'model' => $this->request->getPost('model'),
            'condition' => $this->request->getPost('field').' '.$this->request->getPost('operator').' '.$this->request->getPost('value'),
            'message_template' => $this->request->getPost('message_template'),
            'is_enabled' => $this->request->getPost('is_enabled') ? 1 : 0,
            'limit' => (int)($this->request->getPost('limit') ?? 5),
            'sound_file' => $soundPath
        ]);

        return redirect()->to(base_url('admin/setting/notification'));
    }

    public function update($id)
    {
        $setting = $this->notifModel->find($id);
        if(!$setting) return redirect()->back();

        $soundFile = $this->request->getFile('sound_file');
        $soundPath = $setting['sound_file'];
        if ($soundFile && $soundFile->isValid() && !$soundFile->hasMoved()) {
            $newName = $soundFile->getRandomName();
            $soundFile->move(ROOTPATH.'public/assets/sounds/', $newName);
            $soundPath = 'assets/sounds/'.$newName;
        }

        $this->notifModel->update($id, [
            'type' => $this->request->getPost('type'),
            'model' => $this->request->getPost('model'),
            'condition' => $this->request->getPost('field').' '.$this->request->getPost('operator').' '.$this->request->getPost('value'),
            'message_template' => $this->request->getPost('message_template'),
            'is_enabled' => $this->request->getPost('is_enabled') ? 1 : 0,
            'limit' => (int)($this->request->getPost('limit') ?? 5),
            'sound_file' => $soundPath
        ]);

        return redirect()->to(base_url('admin/setting/notification'));
    }

    public function delete($id)
    {
        $this->notifModel->delete($id);
        return redirect()->to(base_url('admin/setting/notification'));
    }
}
