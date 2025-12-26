<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Admin\CategoryModel;

class CategoryAdminController extends BaseController
{
    protected $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
        helper('text');

    }

    public function index()
    {
        $data['categories'] = $this->categoryModel->findAll();
        return view('admin/categories/index', $data);
    }
    public function create()
    {
        return view('admin/categories/create');
    }

   public function store()
{
    helper(['text']);
    $imageService = \Config\Services::image();

    $name = $this->request->getPost('name');
    $path = url_title($name, '-', true);
    $desc = $this->request->getPost('description');
    $file = $this->request->getFile('img');
    $status = $this->request->getPost('status');

    $imgName = '';

    if (!defined('FCPATH')) {
        define('FCPATH', $_SERVER['DOCUMENT_ROOT'] . '/');
    }

    $safePath = preg_replace('/[^A-Za-z0-9_\-]/', '', $path);

    if ($file && $file->isValid() && !$file->hasMoved()) {
        $extension = $file->getClientExtension();
        $imgName = uniqid() . '.' . $extension;

        $folder = FCPATH . 'assets/SGV/Category/' . $safePath;

        if (!is_dir($folder)) {
            if (!mkdir($folder, 0777, true) && !is_dir($folder)) {
                throw new \RuntimeException(sprintf('Directory "%s" was not created', $folder));
            }
        }

        if (!$file->move($folder, $imgName)) {
            throw new \RuntimeException('Failed to move uploaded file.');
        }

        $imageService->withFile($folder . '/' . $imgName)
                     ->fit(500, 500, 'center')
                     ->save($folder . '/' . $imgName);
    }

    $data = [
        'name'        => $name,
        'path'        => $safePath,
        'description' => $desc,
        'status'      => $status,
        'img'         => $imgName
    ];
    // dd($data);
    $this->categoryModel->save($data);
    

    session()->setFlashdata('success', 'Category created.');
    return redirect()->to('/admin/categories')->with('success', 'Category created');
}




    public function edit($id)
    {
        $data['category'] = $this->categoryModel->find($id);
        return view('admin/categories/edit', $data);
    }

    public function update($id)
    {
        $file = $this->request->getFile('img');
        $imgName = $this->request->getPost('old_img');
        $path = url_title($this->request->getPost('name'), '-', true);
        $safePath = preg_replace('/[^A-Za-z0-9_\-]/', '', $path);

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $imgName = $file->getRandomName();
            
            $folder = FCPATH . 'assets/SGV/Category/' . $safePath;

            if (!is_dir($folder)) {
                if (!mkdir($folder, 0777, true) && !is_dir($folder)) {
                    throw new \RuntimeException(sprintf('Directory "%s" was not created', $folder));
                }
            }
            $file->move($folder. url_title($this->request->getPost('name'), '-', true).'/', $imgName);
        }
        if (!$file->isValid()) {
        echo 'Upload error: ' . $file->getErrorString() . ' (' . $file->getError() . ')';
        exit;
    }

        $this->categoryModel->update($id, [
            'name'   => $this->request->getPost('name'),
            'path'   => url_title($this->request->getPost('name'), '-', true),
            'status' => $this->request->getPost('status'),
            'img'    => $imgName,
        ]);

        session()->setFlashdata('success', 'Category updated.');
        return redirect()->to('/admin/categories')->with('success', 'Category updated');
    }

    public function delete($id)
    {
        $this->categoryModel->delete($id);
        session()->setFlashdata('success', 'Category deleted.');
        return redirect()->to('/admin/categories')->with('success', 'Category deleted');
    }
    
   
}
