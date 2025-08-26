<?php
namespace App\Controllers;
use App\Models\CmsPageModel;

class PageController extends BaseController
{
    public function view($slug = null)
    {
        $model = new CmsPageModel();
        $page = $model->where('slug', $slug)->where('status','published')->first();
        if (!$page) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Page not found');
        }
        echo view('cms/page', ['page' => $page]);
    }
}
