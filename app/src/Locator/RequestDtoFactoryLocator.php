<?php
declare(strict_types=1);

namespace Partitura\Locator;

use Doctrine\Common\Collections\ArrayCollection;
use Partitura\Interfaces\RequestDtoFactoryInterface;

/**
 * Class RequestDtoFactoryLocator
 * @package Partitura\Locator
 */
class RequestDtoFactoryLocator
{
    /** @var ArrayCollection<string, RequestDtoFactoryInterface> */
    protected ArrayCollection $factories;

    public function __construct()
    {
        $this->factories = new ArrayCollection();
    }

    /**
     * @param string $dtoClassName
     * @param RequestDtoFactoryInterface $dtoFactory
     *
     * @return $this
     */
    public function addFactory(string $dtoClassName, RequestDtoFactoryInterface $dtoFactory) : static
    {
        $this->factories->set($dtoClassName, $dtoFactory);

        return $this;
    }

    /**
     * @param string $dtoClassName
     *
     * @return null|RequestDtoFactoryInterface
     */
    public function getFactory(string $dtoClassName) : ?RequestDtoFactoryInterface
    {
        return $this->factories->get($dtoClassName);
    }
}
