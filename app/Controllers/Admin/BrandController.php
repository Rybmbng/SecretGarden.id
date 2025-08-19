<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\BrandModel;

class BrandController extends BaseController
{
    protected $brandModel;

    public function __construct()
    {
        $this->brandModel = new BrandModel();
    }

    // List semua brand
    public function index()
    {
        $data['brands'] = $this->brandModel->findAll();
        return view('admin/page/brand/index', $data);
    }

    // Form create
    public function create()
    {
        return view('admin/page/brand/create');
    }

    // Simpan data baru
    public function store()
    {
        $file = $this->request->getFile('img_path');
        $imgPath = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('assets/SGV/brands/', $newName);
            $imgPath = 'assets/SGV/brand/' . $newName;
        }

        $this->brandModel->save([
            'title'    => $this->request->getPost('title'),
            'content'  => $this->request->getPost('content'),
            'img_path' => $imgPath,
            'position' => $this->request->getPost('position'),
            'year'     => $this->request->getPost('year'),
            'status'   => $this->request->getPost('status'),
        ]);

        return redirect()->to(base_url('admin/page/brand'))->with('success', 'Brand created successfully');
    }

    // Edit form
    public function edit($id)
    {
        $data['brand'] = $this->brandModel->find($id);
        return view('admin/page/brand/edit', $data);
    }

    // Update
    public function update($id)
    {
        $brand = $this->brandModel->find($id);
        $file = $this->request->getFile('img_path');
        $imgPath = $brand['img_path'];

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('assets/SGV/brand', $newName);
            $imgPath = 'assets/SGV/brand/' . $newName;
        }

        $this->brandModel->update($id, [
            'title'    => $this->request->getPost('title'),
            'content'  => $this->request->getPost('content'),
            'img_path' => $imgPath,
            'position' => $this->request->getPost('position'),
            'year'     => $this->request->getPost('year'),
            'status'   => $this->request->getPost('status'),
        ]);

        return redirect()->to(base_url('admin/page/brand'))->with('success', 'Brand updated successfully');
    }

    // Delete
    public function delete($id)
    {
        $brand = $this->brandModel->find($id);
        if ($brand && $brand['img_path'] && file_exists($brand['img_path'])) {
            unlink($brand['img_path']);
        }

        $this->brandModel->delete($id);
        return redirect()->to(base_url('admin/page/brand'))->with('success', 'Brand deleted successfully');
    }
}
