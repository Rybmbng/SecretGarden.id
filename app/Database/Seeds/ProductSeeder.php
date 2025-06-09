<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Lavender Bliss',
                'price' => '250000',
                'image' => 'lavender.jpg',
                'category_id' => 1,
                'description' => 'Aroma lavender yang menenangkan.',
                'slug' => 'lavender-bliss'
            ],
            [
                'name' => 'Mint Fresh Body Lotion',
                'price' => '150000',
                'image' => 'mint.jpg',
                'category_id' => 2,
                'description' => 'Lotion tubuh dengan sensasi mint segar.',
                'slug' => 'mint-fresh-body-lotion'
            ]
        ];

        // Insert batch ke tabel products
        $this->db->table('products')->insertBatch($data);
    }
}
