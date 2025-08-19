<?php

namespace App\Models;

use CodeIgniter\Model;

class StoreModel extends Model
{
    protected $table      = 'stores';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'name',
        'floor',
        'open_hours',
        'phone',
        'map_link',
    ];
}
