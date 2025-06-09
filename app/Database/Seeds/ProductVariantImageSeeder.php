<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class ProductVariantImageSeeder extends Seeder
{
    public function run()
    {
        $db = \Config\Database::connect();

        // Contoh: variant untuk produk ID 1
        $variants = [
            [
                'product_id' => 1,
                'name'       => '150g',
                'price'      => '350000',
                'sku'        => 'SKU150G',
                'stock'      => 10,
            ],
            [
                'product_id' => 1,
                'name'       => '250g',
                'price'      => '450000',
                'sku'        => 'SKU250G',
                'stock'      => 5,
            ],
        ];

        $db->table('product_variants')->insertBatch($variants);

        // Contoh: gambar untuk produk ID 1
        $images = [
            [
                'product_id' => 1,
                'image'      => 'citronnelle-lemongrass-1.jpg',
                'alt_text'   => 'Citronnelle Lemongrass Candle front view',
                'is_main'    => 1,
            ],
            [
                'product_id' => 1,
                'image'      => 'citronnelle-lemongrass-2.jpg',
                'alt_text'   => 'Citronnelle Lemongrass Candle side view',
                'is_main'    => 0,
            ],
        ];

        $db->table('product_images')->insertBatch($images);
    }
}
