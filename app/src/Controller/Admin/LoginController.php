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
    public const ROUTE_LOGIN_FORM = "partitura_admin_login_form";

    /**
     * @param Request $request
     * 
     * @return Response
     * 
     * @Route("/", name=LoginController::ROUTE_LOGIN_FORM, methods={"GET"})
     */
    public function loginForm(Request $request) : Response
    {
        return $this->render("genesis/admin/login.html.twig", $this->getCsrfTokenBase($request));
    }
}
