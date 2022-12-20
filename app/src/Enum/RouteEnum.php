<?php

declare(strict_types=1);

namespace Partitura\Enum;

use Partitura\Controller\Admin\DashboardController;
use Partitura\Controller\Admin\LoginController as AdminLoginController;
use Partitura\Controller\LoginController;
use Partitura\Controller\MainController;
use Partitura\Controller\Profile\BannedController;
use Partitura\Controller\Profile\ProfileController;
use Partitura\Enum\Trait\GetInstanceByValueTrait;
use Partitura\Exception\CaseNotFoundException;

/**
 * Enum RouteEnum
 * @package Partitura\Enum
 */
enum RouteEnum : string
{
    use GetInstanceByValueTrait;

    case INDEX = MainController::ROUTE_INDEX;
    case MAIN_INFO = ProfileController::ROUTE_MAIN_INFO;
    case SECURITY = ProfileController::ROUTE_SECURITY;
    case BANNED = BannedController::ROUTE_BANNED;
    case LOGIN = LoginController::ROUTE_LOGIN;
    case ADMIN_LOGIN = AdminLoginController::ROUTE_LOGIN;
    case DASHBOARD = DashboardController::ROUTE_DASHBOARD;

    /**
     * @throws CaseNotFoundException Throws if view was not found by route.
     * @return string
     */
    public function getView() : string
    {
        return match ($this) {
            default => throw new CaseNotFoundException(sprintf(
                "View by route \"%s\" was not found",
                $this->value
            )),
            self::INDEX => "genesis/main/blog.html.twig",
            self::MAIN_INFO => "genesis/profile/main_info.html.twig",
            self::SECURITY => "genesis/profile/security.html.twig",
            self::BANNED => "genesis/profile/banned.html.twig",
            self::LOGIN => "genesis/admin/login.html.twig",
            self::ADMIN_LOGIN => "genesis/admin/login.html.twig",
            self::DASHBOARD => "",
        };
    }
}
