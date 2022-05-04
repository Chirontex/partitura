<?php
declare(strict_types=1);

namespace Partitura\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LoginController
 * @package Partitura\Controller\Admin
 * 
 * @Route("/admin/login")
 */
class LoginController
{
    /**
     * @return Response
     * 
     * @Route("/", methods={"GET"})
     */
    public function loginForm() : Response
    {
        return new Response("<html><body>test</body></html>");
    }
}
