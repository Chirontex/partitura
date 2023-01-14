<?php

declare(strict_types=1);

namespace Partitura\Interfaces;

use Doctrine\Common\Collections\ArrayCollection;

/**
 * Interface FillerValuesFactoryInterface
 * @package Partitura\Interfaces
 */
interface FillerValuesFactoryInterface
{
    /**
     * Возвращает коллекцию значений полей представления.
     *
     * @return ArrayCollection<string, mixed>
     */
    public function getFillerValuesCollection() : ArrayCollection;

    /**
     * Возвращает представление, значения для полей которого необходимо генерировать данному классу.
     *
     * @return string
     */
    public static function getView() : string;
}
