<?php

declare(strict_types=1);

namespace Partitura\Controller\Profile;

use Partitura\Exception\SystemException;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class LogoutController.
 *
 * @Route("/profile/logout")
 */
class LogoutController
{
    public const ROUTE_LOGOUT = "partitura_profile_logout";

    /**
     * @Route("/", name=LogoutController::ROUTE_LOGOUT, methods={"GET"})
     */
    public function logout(): void
    {
        throw new SystemException("Something is wrong with logout.");
    }
}
