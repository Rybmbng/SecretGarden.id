<?php
namespace App\Models;
use CodeIgniter\Model;

class FooterLinkModel extends Model
{
    protected $table = 'footer_links';
    protected $primaryKey = 'id';
    protected $allowedFields = ['title', 'url', 'position'];
    protected $useTimestamps = true;
}

?>