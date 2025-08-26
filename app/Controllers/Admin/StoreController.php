<?php
namespace App\Controllers\Admin;
use App\Controllers\BaseController;
use App\Models\StoreModel;
use App\Models\StoreImageModel;

class StoreController extends BaseController
{
    public function index()
    {
        $storeModel = new StoreModel();
        $data['stores'] = $storeModel->findAll();
        $data['pageTitle'] = 'Store Management';
        return view('admin/page/stores/index', $data);
    }

    public function create()
    {

        $data['pageTitle'] = 'Store';
        return view('admin/page/stores/create',$data);
    }

    public function store()
    {
        $storeModel = new StoreModel();
        $storeImageModel = new StoreImageModel();

        // simpan data store
        $storeId = $storeModel->insert([
            'name'       => $this->request->getPost('name'),
            'slug'       => url_title($this->request->getPost('name'), '-', true),
            'address'    => $this->request->getPost('address'),
            'phone'      => $this->request->getPost('phone'),
            'open_hours' => $this->request->getPost('open_hours'),
            'map_embed'  => $this->request->getPost('map_embed'),
        ]);

        // upload multiple images
        $files = $this->request->getFiles();
        if ($files && isset($files['images'])) {
            foreach ($files['images'] as $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    $newName = $img->getRandomName();
                    $img->move('assets/SGV/stores', $newName);

                    $storeImageModel->insert([
                        'store_id' => $storeId,
                        'image'    => $newName
                    ]);
                }
            }
        }

        return redirect()->to('/admin/page/stores');
    }

    public function edit($id)
    {
        $storeModel = new StoreModel();
        $storeImageModel = new StoreImageModel();

        $data['store']  = $storeModel->find($id);
        $data['images'] = $storeImageModel->where('store_id', $id)->findAll();

        return view('admin/page/stores/edit', $data);
    }

    public function update($id)
    {
        $storeModel = new StoreModel();
        $storeImageModel = new StoreImageModel();

        $storeModel->update($id, [
            'name'       => $this->request->getPost('name'),
            'slug'       => url_title($this->request->getPost('name'), '-', true),
            'address'    => $this->request->getPost('address'),
            'phone'      => $this->request->getPost('phone'),
            'open_hours' => $this->request->getPost('open_hours'),
            'map_embed'  => $this->request->getPost('map_embed'),
        ]);

        // upload tambahan gambar
        $files = $this->request->getFiles();
        if ($files && isset($files['images'])) {
            foreach ($files['images'] as $img) {
                if ($img->isValid() && !$img->hasMoved()) {
                    $newName = $img->getRandomName();
                    $img->move('assets/SGV/stores', $newName);

                    $storeImageModel->insert([
                        'store_id' => $id,
                        'image'    => $newName
                    ]);
                }
            }
        }

        return redirect()->to('/admin/page/stores/edit/'.$id);
    }

    public function delete($id)
    {
        $storeModel = new StoreModel();
        $storeModel->delete($id);
        return redirect()->to('/admin/stores');
    }
}
