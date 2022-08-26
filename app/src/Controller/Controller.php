<?php
declare(strict_types=1);

namespace Partitura\Controller;

use Partitura\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

/**
 * Abstract Partitura Controller.
 * @package Partitura\Controller
 */
abstract class Controller extends AbstractController
{
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
            "user_identifier" => $user->getUserIdentifier(),
        ];
    }
}
