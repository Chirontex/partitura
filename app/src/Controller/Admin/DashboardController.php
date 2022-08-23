<?php
declare(strict_types=1);

namespace Partitura\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class DashboardController
 * @package Partitura\Controller\Admin
 * 
 * @Route("/admin/dashboard")
 */
class DashboardController extends AbstractController
{
    public const ROUTE_DASHBOARD = "partitura_admin_dashboard";

    /**
     * @return Response
     * 
     * @Route("/", name=DashboardController::ROUTE_DASHBOARD, methods={"GET"})
     */
    public function dashboard() : Response
    {
        return new Response("<html><body>dashboard</body></html>");
    }
}
