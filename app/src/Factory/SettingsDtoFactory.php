<?php

declare(strict_types=1);

namespace Partitura\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use Partitura\Controller\LoginController;
use Partitura\Controller\Profile\LogoutController;
use Partitura\Controller\Profile\ProfileController;
use Partitura\Dto\SettingsDto;
use Partitura\Entity\User;
use Partitura\Service\User\CurrentUserService;

/**
 * Class SettingsDtoFactory.
 */
class SettingsDtoFactory
{
    public function __construct(protected CurrentUserService $currentUserService)
    {
    }

    public function createDto(): SettingsDto
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
                "profile_main_info" => ProfileController::ROUTE_MAIN_INFO,
            ]))
            ->setUserData(new ArrayCollection(
                $user === null ? [] : ["identifier" => $user->getUserIdentifier()]
            ));
    }

    public function createDtoForLoginForm(string $actionRoute): SettingsDto
    {
        $dto = $this->createDto();

        $dto->getRoutes()->set("action", $actionRoute);
        $dto->setUserPanelAvailable(false);

        return $dto;
    }
}
