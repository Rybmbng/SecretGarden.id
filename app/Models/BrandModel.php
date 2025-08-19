<?php

namespace App\Models;

use CodeIgniter\Model;

class BrandModel extends Model
{
    protected $table            = 'brand';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'title', 'content', 'img_path', 'position', 'year', 'status'
    ];

    protected $useTimestamps = true; // kalau tabel ada created_at, updated_at
}
