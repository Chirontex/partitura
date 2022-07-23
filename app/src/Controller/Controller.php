<?php
declare(strict_types=1);

namespace Partitura\Controller;

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
}
