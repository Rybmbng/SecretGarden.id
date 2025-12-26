<?php namespace App\Models;

use CodeIgniter\Model;

class SliderModel extends Model
{
    protected $table = 'sliders';
    protected $primaryKey = 'id';
    protected $allowedFields = ['type', 'srcD', 'srcM', 'alt', 'order','status','duration','compressD_status','compressM_status'];

    public function getSliders()
    {
    return $this->where('status', 1)
                ->where('compressD_status', 'done')
                ->where('compressM_status', 'done')
                ->orderBy('order', 'ASC')
                ->findAll();
    }

}
