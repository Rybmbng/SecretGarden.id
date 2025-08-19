<?php
namespace App\Models;

use CodeIgniter\Model;

class ProfileModel extends Model
{
    protected $table      = 'profile';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'id_user','name','avatar','cover_photo','location','birthday',
        'bio','address','phone'
    ];
}
