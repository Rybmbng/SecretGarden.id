<?php
namespace App\Models;

use CodeIgniter\Model;

class EmailModel extends Model
{
    protected $table = 'emails';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'sender_email','sender_name','subject','body','received_at',
        'replied','is_new','folder','parent_id','account'
    ];
    protected $returnType = 'array';
}
