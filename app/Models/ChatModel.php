<?php 
namespace App\Models;
use CodeIgniter\Model;

class ChatModel extends Model
{
    protected $table = 'chat_messages';
    protected $allowedFields = ['sender_id', 'receiver_id', 'message', 'created_at'];

    public function getUserMessages($userId, $adminId = 1)
    {
        return $this->where("(sender_id = $userId AND receiver_id = $adminId) OR (sender_id = $adminId AND receiver_id = $userId)")
                    ->orderBy('created_at', 'ASC')
                    ->findAll();
    }
}
