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
}
