<?php
namespace App\Models;

use CodeIgniter\Model;

class EmailConfigModel extends Model
{
    protected $table = 'email_settings';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'smtp_host','smtp_user','smtp_pass','smtp_port',
        'imap_host','imap_user','imap_pass','imap_port',
        'mail_type','name'
    ];

    public function getConfig()
    {
        return $this->first();
    }
}
