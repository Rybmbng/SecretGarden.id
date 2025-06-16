<?php
namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\ProductImageModel;
use CodeIgniter\Controller;

class Cart extends Controller
{
    public function index()
    {
        
        $categoryModel = new CategoryModel();
        $productModel = new ProductModel();
        $categories = $categoryModel->findAll();

        foreach ($categories as &$category) {
            $category['products'] = $productModel->where('category_id', $category['id'])->limit(3)->findAll();
            foreach ($category['products'] as &$product) {
                $productImageModel = new ProductImageModel();
                $primaryImage = $productImageModel
                    ->where('product_id', $product['id'])
                    ->where('is_primary', true)
                    ->first();
                $product['img'] = $primaryImage['image_path'] ?? 'default-product.jpg';
            }
        }
        $images = [];
        foreach ($categories as $cat) {
            $images[] = [
                'name' => $cat['name'],
                'img'  => $cat['img'] ?? 'default-category.jpg',
                'desc'  => $cat['description'] ?? 'No description available',
            ];
        }

        $session = session();
        $sesi = $session->get('cart') ?? [];
        $data = [
            'product' => $categories,
            'images' => $images,
            'cart' => $sesi,
        ];
        return view('product/cart', $data);
    }

    public function add($id)
    {
        $session = session();
        $productId = $id;
        $quantity  = 1;

        $productModel = new ProductModel();
        $product = $productModel->find($productId);

        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        $cart = $session->get('cart') ?? [];

        if (isset($cart[$productId])) {
            $cart[$productId]['qty'] += $quantity;
        } else {
            $db = \Config\Database::connect();
            $variant = $db->table('product_variants')
                ->where('product_id', $productId)
                ->get()
                ->getRowArray();

            $image = $db->table('product_images')
                ->where('variant_id', $variant['id'])
                ->get()
                ->getRowArray();
            $category = $db->table('categories')
                ->where('id', $product['category_id'])
                ->select('name')
                ->get()
                ->getRowArray();

            $cart[$productId] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'qty' => $quantity,
                'price' => $variant['price'],
                'category' => $category['name'] ?? 'Uncategorized',
                'variant' => $variant['name'] ?? 'Default Variant',
                'image' => $image['image_path'] ?? 'default-product.jpg',
            ];
        }

        $session->set('cart', $cart);
        return redirect()->to('/cart')->with('success', 'Produk ditambahkan ke keranjang.');
    }
    
    public function min($id){
        $session = session();
        $productId = $id;
        $cart = $session->get('cart') ?? [];

        if (isset($cart[$productId])) {
            if ($cart[$productId]['qty'] > 1) {
                $cart[$productId]['qty']--;
            } else {
                unset($cart[$productId]);
            }
            $session->set('cart', $cart);
        }

        return redirect()->to('/cart')->with('success', 'Jumlah produk dikurangi.');
    }

    public function remove($id)
    {
        $session = session();
        $cart = $session->get('cart') ?? [];

        if (isset($cart[$id])) {
            unset($cart[$id]);
            $session->set('cart', $cart);
        }

        return redirect()->to('/cart')->with('success', 'Produk dihapus dari keranjang.');
    }
}