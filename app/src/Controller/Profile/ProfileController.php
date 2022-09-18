<?php
declare(strict_types=1);

namespace Partitura\Controller\Profile;

use Partitura\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProfileController
 * @package Partitura\Controller\Profile
 * 
 * @Route("/profile")
 */
class ProfileController extends Controller
{
    public const ROUTE_PROFILE = "partitura_profile";

    /**
     * @return Response
     * 
     * @Route("/", name=ProfileController::ROUTE_PROFILE, methods={"GET"})
     */
    public function profile() : Response
    {
        return $this->render("genesis/profile/profile.html.twig");
    }
}
