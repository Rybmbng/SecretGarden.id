<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class DummyProductSeeder extends Seeder
{
    public function run()
    {
        // Tambah kategori
        $categories = [
            ['name' => 'Fragrance', 'description' => 'Parfum dan aroma terapi'],
            ['name' => 'Body Care', 'description' => 'Perawatan tubuh'],
        ];

        foreach ($categories as $category) {
            $this->db->table('categories')->insert([
                'name'        => $category['name'],
                'description' => $category['description'],
                'created_at'  => Time::now(),
            ]);
        }

        // Ambil ID kategori
        $categoryModel = new \App\Models\CategoryModel();
        $fragranceID = $categoryModel->where('name', 'Fragrance')->first()['id'];
        $bodyCareID  = $categoryModel->where('name', 'Body Care')->first()['id'];

        // Tambah produk dummy
        $products = [
            [
                'name' => 'Aromatic Candle',
                'slug' => url_title('Aromatic Candle', '-', true),
                'category_id' => $fragranceID,
                'price' => 150000,
                'img' => 'aromatic-candle.jpg',
            ],
            [
                'name' => 'Body Lotion Rose',
                'slug' => url_title('Body Lotion Rose', '-', true),
                'category_id' => $bodyCareID,
                'price' => 99000,
                'img' => 'body-lotion-rose.jpg',
            ],
        ];

        foreach ($products as $product) {
            $this->db->table('products')->insert(array_merge($product, [
                'created_at' => Time::now(),
            ]));
        }
    }
}
