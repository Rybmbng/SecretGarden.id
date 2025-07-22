<?php 
namespace App\Controllers;
use App\Models\ChatModel;

class ChatController extends BaseController
{
    protected $chatModel;

    public function __construct()
    {
        $this->chatModel = new ChatModel();
    }

    public function fetchBubble()
    {
        $userId = session()->get('user_id');
        $adminId = 1; // Admin tetap
        $messages = $this->chatModel->getUserMessages($userId, $adminId);
        return view('partials/message_list', ['messages' => $messages]);
    }

    public function sendBubble()
    {
        $senderId = session()->get('user_id');
        $receiverId = 1; // Admin tetap
        $message = $this->request->getPost('message');

        $this->chatModel->insert([
            'sender_id' => $senderId,
            'receiver_id' => $receiverId,
            'message' => $message,
        ]);

        return $this->response->setJSON(['status' => 'ok']);
    }
}
