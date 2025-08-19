<?php

namespace App\Models;

use CodeIgniter\Model;

class FindusModel extends Model
{
    protected $table            = 'findus';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'title', 'address', 'status',
    ];

    protected $useTimestamps = true;
}
