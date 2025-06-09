<?php

namespace App\Models;

use CodeIgniter\Model;

class ProductVariantModel extends Model
{
    protected $table      = 'product_variants';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'product_id',
        'name',      // contoh: '150g', '190g', '250g', atau warna, ukuran, dll
        'price',
        'sku',       // opsional, kode varian
        'stock',     // opsional, stok varian
    ];

    protected $useTimestamps = true; // kalau pakai created_at dan updated_at
}

class ProductImageModel extends Model
{
    protected $table      = 'product_images';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'product_id',
        'image',  // nama file atau path gambar
        'alt_text', // opsional, deskripsi gambar
        'is_main',  // boolean: true jika gambar utama untuk produk ini
    ];

    protected $useTimestamps = true;
}
