<?php

declare(strict_types=1);

namespace Partitura\Controller\Profile;

use Partitura\Controller\Controller;
use Partitura\Interfaces\ViewResolverInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BannedController.
 *
 * @Route("profile/banned")
 */
class BannedController extends Controller
{
    public const ROUTE_BANNED = "partitura_profile_banned";

    public function __construct(protected ViewResolverInterface $viewResolver)
    {
    }

    /**
     *
     * @Route("/", name=BannedController::ROUTE_BANNED)
     */
    public function banned(): Response
    {
        return $this->render($this->viewResolver->resolveViewByRoute(self::ROUTE_BANNED));
    }
}
