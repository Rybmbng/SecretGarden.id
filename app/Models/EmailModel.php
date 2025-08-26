<?php
namespace App\Models;

use CodeIgniter\Model;

class EmailModel extends Model
{
    protected $table = 'emails';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'uid','subject','from_email','to_email','body','date','folder','is_seen'
    ];
}
