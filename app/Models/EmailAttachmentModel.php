<?php
namespace App\Models;

use CodeIgniter\Model;

class EmailAttachmentModel extends Model
{
    protected $table = 'email_attachments';
    protected $primaryKey = 'id';
    protected $allowedFields = ['email_id','file_name','file_path','mime_type'];
}
