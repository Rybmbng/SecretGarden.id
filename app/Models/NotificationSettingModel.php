<?php
namespace App\Models;

use CodeIgniter\Model;

class NotificationSettingModel extends Model
{
    protected $table = 'notification_settings';
    protected $primaryKey = 'id';
    protected $allowedFields = ['type','model','condition','message_template','is_enabled','limit','sound_file'];
    protected $useTimestamps = true; 
}
