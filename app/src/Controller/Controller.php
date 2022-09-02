<?php
declare(strict_types=1);

namespace Partitura\Controller;

use Partitura\Controller\Profile\LogoutController;
use Partitura\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Abstract Partitura Controller.
 * @package Partitura\Controller
 */
abstract class Controller extends AbstractController
{
    /** {@inheritDoc} */
    protected function render(
        string $view,
        array $parameters = [],
        ?Response $response = null
    ) : Response {
        return parent::render($view, $this->prepareParameters($parameters), $response);
    }

    /**
     * @param array<string, mixed> $parameters
     *
     * @return array<string, mixed>
     */
    protected function prepareParameters(array $parameters = []) : array
    {
        return array_merge($parameters, $this->getSettings());
    }

    /**
     * @return array<string, mixed>
     */
    protected function getSettings() : array
    {
        return [
            "sitename" => $this->getSitename(),
            "is_user_panel_available" => $this->isUserPanelAvailable(),
            "routes" => [
                "login" => LoginController::ROUTE_LOGIN,
                "logout" => LogoutController::ROUTE_LOGOUT,
            ],
            "user" => $this->getUserData(),
        ];
    }

    /**
     * @return string
     */
    protected function getSitename() : string
    {
        // TODO: Реализовать получение имени сайта из настроек, когда настройки будут реализованы.
        return "Partitura";
    }

    /**
     * @return bool
     */
    protected function isUserPanelAvailable() : bool
    {
        // TODO: Реализовать получение этой настройки из БД.
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    protected function getUserData() : array
    {
        /** @var null|User */
        $user = $this->getUser();

        return $user === null ? [] : [
            "identifier" => $user->getUserIdentifier(),
        ];
    }
}
