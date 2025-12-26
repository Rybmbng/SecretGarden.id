<?php

namespace App\Controllers;
use App\Models\ProductModel;

class ChatController extends BaseController
{
    public function reply()
    {
        $message = $this->request->getPost('message');

        if (!$message) {
            return $this->response->setJSON(['reply' => 'Pesan kosong']);
        }

        $token = "Bearer G6TQY63JHX7VQ7S7KYT5LMPTENTIVRUP";

        try {
            $client = \Config\Services::curlrequest();
            $response = $client->request('GET', 'https://api.wit.ai/message', [
                'headers' => [
                    'Authorization' => $token,
                ],
                'query' => [
                    'v' => '20230818',
                    'q' => $message
                ]
            ]);

            $data = json_decode($response->getBody(), true);

            $reply = 'Maaf, saya belum paham maksudmu.';

            if (!empty($data['intents'])) {
                $intent = $data['intents'][0]['name'];

                switch ($intent) {
                    case 'greeting':
                        $greeting = $data['entities']['greeting:greeting'][0]['value'] ?? null;
                        if($greeting){
                            $reply = 'Iya ada yang bisa di bantu';
                        }else{
                            $reply = 'Halo! Selamat datang di SecretGarden.id 🌿';
                        }
                        break;

                    case 'product_inquiry':
                        $asking = $data['entities']['asking:asking'][0]['value'] ?? null;
                        $topic = $data['entities']['topic:topic'][0]['value'] ?? null;
                        if ($asking && $topic) {
                                $productname = $data['entities']['product_name:product_name'][0]['value'] ?? null;
                                    if($productname){
                                        $productModel = new ProductModel();
                                        $product = $productModel
                                            ->select('product_variants.stock as stok')
                                            ->join('product_variants', 'product_variants.product_id = products.id', 'inner')
                                            ->join('categories', 'categories.id = products.category_id', 'inner')
                                            ->where('products.name LIKE', "%{$productname}%")
                                            ->groupBy('product_variants.id')
                                            ->findall(1); 
                                        $reply = "Product ".$productname." Tersisa ".$product['stok'] ;
                                    }else{
                                        $reply = "Produk '$productname' Tidak tersedia.";
                                    }
                        } else {
                            $reply = 'Produk apa yang ingin Anda tanyakan?';
                        }
                        break;

                    case 'order_status':
                        $orderNumber = $data['entities']['order_number:order_number'][0]['value'] ?? null;
                        if ($orderNumber) {
                            $reply = "Status pesanan #$orderNumber: Sedang diproses.";
                        } else {
                            $reply = 'Silakan beri tahu nomor pesanan Anda.';
                        }
                        break;

                    case 'faq_shipping':
                        $reply = 'Biaya pengiriman tergantung lokasi. Silakan masukkan alamat untuk cek ongkir.';
                        break;

                    default:
                        $reply = 'Maaf, saya belum mengerti maksudmu.';
                }
            }

        } catch (\Exception $e) {
            return $this->response->setJSON([
                'reply' => 'Terjadi kesalahan: ' . $e->getMessage()
            ]);
        }

        return $this->response->setJSON([
            'reply' => $reply,
            'wit_response' => $data ?? null
        ]);
    }
}
