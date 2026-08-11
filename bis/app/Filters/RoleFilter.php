<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * RoleFilter
 *
 * Checks that the logged-in user has one of the allowed roles.
 *
 * Usage in Routes.php:
 *   'filter' => 'auth|role:captain'
 *   'filter' => 'auth|role:captain,secretary'
 */
class RoleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $userRole = session()->get('role');

        // $arguments is an array of allowed roles passed after the colon
        if (empty($arguments) || ! in_array($userRole, $arguments, true)) {
            // Redirect back to their own dashboard or login
            return redirect()->to('/login')->with('error', 'You do not have permission to access that page.');
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // nothing needed after
    }
}
