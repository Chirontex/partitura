<?php
declare(strict_types=1);

namespace Partitura\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use Partitura\Controller\LoginController;
use Partitura\Controller\Profile\LogoutController;
use Partitura\Dto\SettingsDto;
use Partitura\Entity\User;
use Partitura\Service\User\CurrentUserService;

/**
 * Class SettingsDtoFactory
 * @package Partitura\Factory
 */
class SettingsDtoFactory
{
    /** @var CurrentUserService */
    protected $currentUserService;

    public function __construct(CurrentUserService $currentUserService)
    {
        $this->currentUserService = $currentUserService;
    }

    /**
     * @return SettingsDto
     */
    public function createDto() : SettingsDto
    {
        /** @var null|User */
        $user = $this->currentUserService->getCurrentUser();

        // TODO: реализовать получение захардкоженных настроек из БД
        return (new SettingsDto())
            ->setSitename("Partitura")
            ->setUserPanelAvailable(true)
            ->setRoutes(new ArrayCollection([
                "login" => LoginController::ROUTE_LOGIN,
                "logout" => LogoutController::ROUTE_LOGOUT,
            ]))
            ->setUserData(new ArrayCollection(
                $user === null ? [] : ["identifier" => $user->getUserIdentifier()]
            ));
    }
}
