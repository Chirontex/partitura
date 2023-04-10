<?php

declare(strict_types=1);

namespace Partitura\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdminController
 *
 * @Route("/admin")
 */
class AdminController extends AbstractController
{
    public const ROUTE_ADMIN = "partitura_admin";

    /**
     *
     * @Route("/", name=AdminController::ROUTE_ADMIN, methods={"GET"})
     */
    public function admin(): Response
    {
        if ($this->getUser() === null) {
            return $this->redirectToRoute(LoginController::ROUTE_LOGIN);
        }

        return $this->redirectToRoute(DashboardController::ROUTE_DASHBOARD);
    }
}
