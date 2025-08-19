<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class AuthFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session = session();
        if (!$session->has('user')) {
            return redirect()->to('/login');
        }

        if ($arguments) {
            $userRole = $session->get('user')['role_id'];
            if (!in_array($userRole, $arguments)) {
                return redirect()->to('/forbidden');
            }
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null) {}
}
