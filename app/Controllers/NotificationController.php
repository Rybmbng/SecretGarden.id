<?php
namespace App\Controllers;

use App\Models\NotificationModel;

class NotificationController extends BaseController
{
    public function getNotifications()
    {
        $notificationModel = new NotificationModel();
        $notifications = $notificationModel
            ->where('is_read', 0)
            ->orderBy('created_at', 'DESC')
            ->findAll(5);

        return $this->response->setJSON($notifications);
    }

    public function markAsRead($id)
    {
        $notificationModel = new NotificationModel();
        $notificationModel->update($id, ['is_read' => 1]);
        return $this->response->setJSON(['status' => 'success']);
    }

    public function uploadSound()
    {
        $file = $this->request->getFile('sound');
        if ($file && $file->isValid() && $file->getExtension() === 'mp3') {
            $newName = $file->getRandomName();
            $file->move(WRITEPATH.'uploads/sounds', $newName);

            // Simpan path ke DB / session / config
            session()->set('notif_sound', base_url('writable/uploads/sounds/'.$newName));

            return $this->response->setJSON([
                'status' => 'success',
                'path' => base_url('writable/uploads/sounds/'.$newName)]
            );
        }

        return $this->response->setJSON(['status'=>'error','message'=>'Invalid file']);
    }

}
