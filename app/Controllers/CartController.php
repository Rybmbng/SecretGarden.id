<?php
namespace App\Controllers;

use App\Models\ProductModel;
use App\Models\CategoryModel;
use App\Models\ProductImageModel;
use App\Models\ProductVariantModel;
use CodeIgniter\Controller;

class CartController extends Controller
{
    public function index()
    {
        $categoryModel = new CategoryModel();
        $productModel = new ProductModel();
        $categories = $categoryModel->findAll();

        foreach ($categories as &$category) {
            $category['products'] = $productModel
                ->select('categories.name as caty,products.*, product_variants.price as variant_price, product_variants.name as variant_name, product_variants.id as variant_id')
                ->join('product_variants', 'product_variants.product_id = products.id', 'inner')
                ->join('categories', 'categories.id = products.category_id', 'inner')
                ->where('products.category_id', $category['id'])
                ->groupBy('product_variants.id')
                ->limit(3)
                ->findAll();

            foreach ($category['products'] as &$product) {
                $productImageModel = new ProductImageModel();
                $primaryImage = $productImageModel
                    ->where('product_id', $product['id'])
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
            'pageTitle' => 'Cart',
        ];
        return view('product/cart', $data);
    }

    public function add($id,$var)
    {
        $session = session();
        $productId = $id;
        $quantity  = 1;
        // dd($id,$var);
        $productModel = new ProductModel();
        $product = $productModel->find($productId);

        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        $cart = $session->get('cart') ?? [];

        if (isset($cart[$var])) {
            $cart[$var]['qty'] += $quantity;
        } else {
            $db = \Config\Database::connect();
            $variant = $db->table('product_variants')
                ->where('id', $var)
                ->get()
                ->getRowArray();

            $image = $db->table('product_images')
                ->where('variant_id', $var)
                ->get()
                ->getRowArray();
            $category = $db->table('categories')
                ->where('id', $product['category_id'])
                ->select('name')
                ->get()
                ->getRowArray();

            $cart[$var] = [
                'id' => $product['id'],
                'name' => $product['name'],
                'qty' => $quantity,
                'price' => $variant['price'],
                'category' => $category['name'] ?? 'Uncategorized',
                'variant' => $variant['name'] ?? 'Default Variant',
                'idVariant' => $variant['id'] ?? 'Default Variant',
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