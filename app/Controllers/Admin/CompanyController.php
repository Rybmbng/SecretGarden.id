<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CompanySettingModel;

class CompanyController extends BaseController
{
    protected $companyModel;

    public function __construct()
    {
        $this->companyModel = new CompanySettingModel();
    }

    public function index()
    {
        $company = $this->companyModel->first();
        return view('admin/setting/company/index', compact('company'));
    }


    public function update()
    {
        $id = $this->request->getPost('id');
        $data = [
            'name'    => $this->request->getPost('name'),
            'tagline' => $this->request->getPost('tagline')
        ];

        if ($logo = $this->request->getFile('logo')) {
            if ($logo->isValid() && !$logo->hasMoved()) {
                $newName = $logo->getRandomName();
                $logo->move('uploads/logo', $newName);
                $data['logo'] = 'uploads/logo/' . $newName;
            }
        }

        if ($favicon = $this->request->getFile('favicon')) {
            if ($favicon->isValid() && !$favicon->hasMoved()) {
                $newName = $favicon->getRandomName();
                $favicon->move('uploads/favicon', $newName);
                $data['favicon'] = 'uploads/favicon/' . $newName;
            }
        }

        $this->companyModel->update(1, $data);

        return redirect()->back()->with('success', 'Company updated');
    }
}
