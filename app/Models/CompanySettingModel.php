<?php namespace App\Models;

use CodeIgniter\Model;

class CompanySettingModel extends Model
{
    protected $table      = 'company_settings';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'name', 'logo', 'favicon', 'tagline', 'font', 'base_color',
    ];
}
