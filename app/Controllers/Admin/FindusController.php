<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FindusModel;

class FindusController extends BaseController
{
    protected $findusModel;

    public function __construct()
    {
        $this->findusModel = new FindusModel();
    }

    // List semua findus
    public function index()
    {
        $data['store'] = $this->findusModel->findAll();
        return view('admin/page/findus/index', $data);
    }

    // Form create
    public function create()
    {
        return view('admin/page/findus/create');
    }

    // Simpan data baru
    public function store()
    {
        $file = $this->request->getFile('img_path');
        $imgPath = null;

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('assets/SGV/finduss/', $newName);
            $imgPath = 'assets/SGV/findus/' . $newName;
        }

        $this->findusModel->save([
            'title'    => $this->request->getPost('title'),
            'address'  => $this->request->getPost('address'),
            'status'   => $this->request->getPost('status'),
        ]);

        return redirect()->to(base_url('admin/page/findus'))->with('success', 'findus created successfully');
    }

    // Edit form
    public function edit($id)
    {
        $data['findus'] = $this->findusModel->find($id);
        return view('admin/page/findus/edit', $data);
    }

    // Update
    public function update($id)
    {
        $findus = $this->findusModel->find($id);
        $file = $this->request->getFile('img_path');
        $imgPath = $findus['img_path'];

        if ($file && $file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move('assets/SGV/findus', $newName);
            $imgPath = 'assets/SGV/findus/' . $newName;
        }

        $this->findusModel->update($id, [
            'title'    => $this->request->getPost('title'),
            'address'  => $this->request->getPost('address'),
            'status'   => $this->request->getPost('status'),
        ]);

        return redirect()->to(base_url('admin/page/findus'))->with('success', 'findus updated successfully');
    }

    // Delete
    public function delete($id)
    {
        $this->findusModel->delete($id);
        return redirect()->to(base_url('admin/page/findus'))->with('success', 'findus deleted successfully');
    }
}
