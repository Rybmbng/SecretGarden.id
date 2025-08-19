<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\FooterLinkModel;

class FooterController extends BaseController
{
    protected $footerModel;

    public function __construct()
    {
        $this->footerModel = new FooterLinkModel();
    }

    public function index()
    {
        $links = $this->footerModel->orderBy('position', 'ASC')->findAll();
        return view('admin/setting/footer/index', compact('links'));
    }

    public function create()
    {
        $data = $this->request->getPost();
        $this->footerModel->insert($data);
        return redirect()->back()->with('success', 'Link added');
    }

    public function update($id)
    {
        $data = $this->request->getPost();
        $this->footerModel->update($id, $data);
        return redirect()->back()->with('success', 'Link updated');
    }

    public function delete($id)
    {
        $this->footerModel->delete($id);
        return redirect()->back()->with('success', 'Link deleted');
    }
}
