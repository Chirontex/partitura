<?php
declare(strict_types=1);

namespace Partitura\Controller\Profile;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BannedController
 * @package Partitura\Controller\Profile
 * 
 * @Route("profile/banned")
 */
class BannedController extends AbstractController
{
    public const ROUTE_BANNED = "partitura_profile_banned";

    /**
     * @return Response
     * 
     * @Route("/", name=BannedController::ROUTE_BANNED)
     */
    public function banned() : Response
    {
        return $this->render("genesis/profile/banned.html.twig");
    }
}
