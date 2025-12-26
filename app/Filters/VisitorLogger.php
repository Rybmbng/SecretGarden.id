<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Models\VisitorModel;

class VisitorLogger implements FilterInterface
{
   public function before(RequestInterface $request, $arguments = null)
    {
        $ip = $request->getServer('HTTP_X_FORWARDED_FOR'); 
        if (!$ip) {
            $ip = $request->getServer('HTTP_X_REAL_IP'); 
        }
        if (!$ip) {
            $ip = $request->getIPAddress();
        }

        $visitorModel = new VisitorModel();
        $visitorModel->insert([
            'ip_address' => $ip,
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? '',
            'page'       => current_url(),
            'country'    => null,
        ]);
    }
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // tidak dipakai
    }


}
