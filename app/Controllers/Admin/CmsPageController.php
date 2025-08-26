<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\CmsPageModel;

class CmsPageController extends BaseController
{
    protected $cmsModel;

    public function __construct()
    {
        $this->cmsModel = new CmsPageModel();
    }

    public function index()
    {
        $pages = $this->cmsModel->orderBy('updated_at', 'DESC')->findAll();
        echo view('admin/cms/index', ['pages' => $pages]);
    }

    public function create()
    {
        echo view('admin/cms/create');        
     
    }

    public function store()
    {
        helper('text');
        $title = $this->request->getPost('title');
        $slug = $this->request->getPost('slug') ?: url_title($title, '-', true);
        // basic uniqueness check
        $exists = $this->cmsModel->where('slug', $slug)->first();
        if ($exists) {
            return redirect()->back()->with('error', 'Slug already exists.')->withInput();
        }

        $this->cmsModel->save([
            'title' => $title,
            'slug'  => $slug,
            'content' => $this->request->getPost('content'),
            'status' => $this->request->getPost('status') ?? 'draft',
        ]);
        return redirect()->to('/admin/cms')->with('success', 'Page created.');
    }

    public function edit($id = null)
    {
        $page = $this->cmsModel->find($id);
        if (!$page) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Page not found');
        }
        echo view('admin/cms/edit', ['page' => $page]);
        
    }

    public function update($id = null)
    {
        $data = [
            'title' => $this->request->getPost('title'),
            'slug'  => $this->request->getPost('slug'),
            'content' => $this->request->getPost('content'),
            'status' => $this->request->getPost('status') ?? 'draft',
        ];
        $this->cmsModel->update($id, $data);
        return redirect()->to('/admin/cms')->with('success', 'Page updated.');
    }

    public function delete($id = null)
    {
        $this->cmsModel->delete($id);
        return redirect()->to('/admin/cms')->with('success', 'Page deleted.');
    }
}
