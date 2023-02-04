<?php

declare(strict_types=1);

namespace Partitura\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use Partitura\Interfaces\FillerValuesFactoryInterface;

/**
 * Class SecurityFillerValuesFactory
 * @package Partitura\Factory
 *
 * Этот класс - заглушка. На данный момент на странице безопасности можно только поменять пароль и сбросить токены. Ничто из этого не требует возврата дефолтных значений из базы.
 */
class SecurityFillerValuesFactory implements FillerValuesFactoryInterface
{
    /** {@inheritDoc} */
    public function getFillerValuesCollection() : ArrayCollection
    {
        // Нам не нужно возвращать корректный пароль из БД.
        return new ArrayCollection();
    }

    /** {@inheritDoc} */
    public static function getView() : string
    {
        return "genesis/profile/security.html.twig";
    }
}
