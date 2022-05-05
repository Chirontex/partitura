<?php
declare(strict_types=1);

namespace Partitura\Controller\Admin;

use Partitura\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LoginController
 * @package Partitura\Controller\Admin
 * 
 * @Route("/admin/login")
 */
class LoginController extends Controller
{
    /**
     * @return Response
     * 
     * @Route("/", name="partitura_admin_login_form", methods={"GET"})
     */
    public function loginForm(Request $request) : Response
    {
        return $this->render("genesis/admin/login.html.twig", $this->getCsrfTokenBase($request));
    }
}
