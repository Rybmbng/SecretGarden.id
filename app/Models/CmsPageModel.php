<?php
namespace App\Models;
use CodeIgniter\Model;

class CmsPageModel extends Model
{
    protected $table = 'cms_pages';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title','slug','content','status','created_at','updated_at'];
    protected $useTimestamps = true;
    protected $dateFormat = 'datetime';
}
