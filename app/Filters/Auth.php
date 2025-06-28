<?php
namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (!session()->get('logged_in')) {
            return redirect()->to('/login');
        }

        // Role-based access check
        $userRole = session()->get('role');
        $currentRoute = $request->uri->getSegment(1);

        if ($userRole === 'admin' && $currentRoute !== 'admin') {
            return redirect()->to('/admin');
        }

        // Similar checks for other roles...
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}