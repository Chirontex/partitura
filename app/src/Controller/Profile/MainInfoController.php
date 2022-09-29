<?php
declare(strict_types=1);

namespace Partitura\Controller\Profile;

use Partitura\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MainInfoController
 * @package Partitura\Controller\Profile
 * 
 * @Route("/profile")
 */
class MainInfoController extends Controller
{
    public const ROUTE_MAIN_INFO = "partitura_main_info";

    /**
     * @return Response
     * 
     * @Route("/", name=MainInfoController::ROUTE_MAIN_INFO, methods={"GET"})
     */
    public function profile() : Response
    {
        return $this->render("genesis/profile/main_info.html.twig");
    }
}
