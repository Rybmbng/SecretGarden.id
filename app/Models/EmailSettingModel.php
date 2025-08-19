<?php

namespace App\Models;
use CodeIgniter\Model;

class EmailSettingModel extends Model
{
    protected $table = 'email_settings';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'smtp_host','smtp_user','smtp_pass','smtp_port','smtp_crypto','from_email','to_email'];
}