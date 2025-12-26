<?php

namespace App\Models;

use CodeIgniter\Model;

class SubscribeModel extends Model
{
    protected $table = 'subscribe';
    protected $primaryKey = 'id';
    protected $allowedFields = ['username', 'email', 'is_active', 'created_at', 'updated_at'];
    protected $useTimestamps = False;
}
