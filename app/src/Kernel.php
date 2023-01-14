<?php
declare(strict_types=1);

namespace Partitura;

use Partitura\DependencyInjection\FillerValuesFactoryCompilerPass;
use Partitura\DependencyInjection\RequestDtoFactoryCompilerPass;
use Partitura\Exception\SystemException;
use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Kernel\MicroKernelTrait;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Exception\InvalidArgumentException;
use Symfony\Component\DependencyInjection\Exception\ServiceCircularReferenceException;
use Symfony\Component\DependencyInjection\Exception\ServiceNotFoundException;
use Symfony\Component\HttpKernel\Kernel as BaseKernel;

/**
 * Class Kernel
 * @package Partitura
 */
class Kernel extends BaseKernel
{
    use MicroKernelTrait;

    /**
     * @throws SystemException
     * @return static
     */
    public static function getInstance() : static
    {
        global $app;

        if ($app instanceof static) {
            return $app;
        }

        if ($app instanceof Application) {
            return $app->getKernel();
        }

        throw new SystemException("Kernel doesn't initialized properly.");
    }

    /**
     * @param string $id
     *
     * @throws ServiceCircularReferenceException
     * @throws ServiceNotFoundException
     * @return object
     */
    public function getService(string $id) : object
    {
        return $this->getContainer()->get($id);
    }

    /**
     * @param string $name
     *
     * @throws InvalidArgumentException
     * @return mixed
     */
    public function getParameter(string $name) : mixed
    {
        return $this->getContainer()->getParameter($name);
    }

    /** {@inheritDoc} */
    protected function build(ContainerBuilder $container) : void
    {
        parent::build($container);

        $container
            ->addCompilerPass(new RequestDtoFactoryCompilerPass())
            ->addCompilerPass(new FillerValuesFactoryCompilerPass());
    }
}
