<?php
declare(strict_types=1);

namespace Partitura\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LoginController
 * @package Partitura\Controller\Admin
 * 
 * @Route("/admin/login")
 */
class LoginController extends AbstractController
{
    /**
     * @return Response
     * 
     * @Route("/", methods={"GET"})
     */
    public function loginForm() : Response
    {
        return $this->render("genesis/admin/login.html.twig");
    }
}
