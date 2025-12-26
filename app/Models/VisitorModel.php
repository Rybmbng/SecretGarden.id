<?php

namespace App\Models;
use CodeIgniter\Model;

class VisitorModel extends Model
{
    protected $table = 'visitors';
    protected $allowedFields = ['ip_address','user_agent','page','country','created_at','location'];
    protected $useTimestamps = true;
}
