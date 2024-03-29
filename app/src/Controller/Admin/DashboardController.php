<?php

declare(strict_types=1);

namespace Partitura\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DashboardController.
 *
 * @Route("/admin/dashboard")
 */
class DashboardController extends AbstractController
{
    public const ROUTE_DASHBOARD = "partitura_admin_dashboard";

    /**
     *
     * @Route("/", name=DashboardController::ROUTE_DASHBOARD, methods={"GET"})
     */
    public function dashboard(): Response
    {
        // TODO: брать представление через ViewResolver, когда будет заведено.
        return new Response("<html><body>dashboard</body></html>");
    }
}
