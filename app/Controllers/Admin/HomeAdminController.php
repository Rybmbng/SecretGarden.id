<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\SliderModel;

class HomeAdminController extends BaseController
{
    protected $sliderModel;

    public function __construct()
    {
        $this->sliderModel = new SliderModel();
    }

    public function index()
    {
        $slider = $this->sliderModel->findAll();

        return view('admin/page/home/index', [
            'pageTitle' => 'Management Dashboard',
            'slider'    => $slider,
        ]);
    }

    public function config()
    {
        return view('admin/home');
    }

    public function createSlider()
    {
        return view('admin/page/home/slider/create');
    }

    public function storeSlider()
    {
        $file = $this->request->getFile('file');
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $ext  = strtolower($file->getExtension());
            $type = in_array($ext, ['mp4','webm','ogg']) ? 'video' : 'image';

            $newName = $file->getRandomName();
            $file->move(FCPATH.'assets/SGV/Page/Home', $newName);

            $this->sliderModel->save([
                'type'     => $type,
                'src'      => 'assets/SGV/Page/Home/'.$newName,
                'alt'      => $this->request->getPost('alt'),
                'duration' => $this->request->getPost('duration') ?? 5000,
            ]);
        }

        return redirect()->to('/admin/page/home');
    }

    public function deleteSlider($id)
    {
        $slider = $this->sliderModel->find($id);

        // hapus file fisik juga
        if ($slider && is_file(FCPATH.$slider['src'])) {
            unlink(FCPATH.$slider['src']);
        }

        $this->sliderModel->delete($id);
        return redirect()->to('/admin/page/home');
    }

    public function editSlider($id)
    {
        $data['slider'] = $this->sliderModel->find($id);
        return view('admin/page/home/slider/edit', $data);
    }

    public function updateSlider($id)
    {
        $slider = $this->sliderModel->find($id);

        $file = $this->request->getFile('file');
        $data = [
            'alt'      => $this->request->getPost('alt'),
            'duration' => $this->request->getPost('duration'),
            'status' => $this->request->getPost('status'),
        ];

        // kalau ada file baru
        if ($file && $file->isValid() && !$file->hasMoved()) {
            $ext  = strtolower($file->getExtension());
            $type = in_array($ext, ['mp4','webm','ogg']) ? 'video' : 'image';

            $newName = $file->getRandomName();
            $file->move(FCPATH.'assets/SGV/Page/Home', $newName);

            $data['src']  = 'assets/SGV/Page/Home/'.$newName;
            $data['type'] = $type;

            // hapus file lama
            if ($slider && is_file(FCPATH.$slider['src'])) {
                unlink(FCPATH.$slider['src']);
            }
        }

        $this->sliderModel->update($id, $data);

        return redirect()->to('/admin/page/home/slider/edit/'.$id)
                         ->with('success', 'Slider berhasil diupdate!');
    }
}
