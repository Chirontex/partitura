<?php
declare(strict_types=1);

namespace Partitura\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 * @package Partitura\Controller\Admin
 * 
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    public const ROUTE_ADMIN = "partitura_admin";

    /**
     * @return Response
     * 
     * @Route("/", name=AdminController::ROUTE_ADMIN, methods={"GET"})
     */
    public function admin() : Response
    {
        if ($this->getUser() === null) {
            return $this->redirectToRoute(LoginController::ROUTE_LOGIN);
        }

        return $this->redirectToRoute(DashboardController::ROUTE_DASHBOARD);
    }
}
