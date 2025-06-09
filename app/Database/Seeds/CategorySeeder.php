<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Fragrance',
                'img' => 'fragrance.jpg',
                'description' => 'Produk parfum terbaik kami.'
            ],
            [
                'name' => 'Body Care',
                'img' => 'bodycare.jpg',
                'description' => 'Perawatan tubuh alami dan menyegarkan.'
            ]
        ];

        // Insert batch ke tabel categories
        $this->db->table('categories')->insertBatch($data);
    }
}
