<?php
declare(strict_types=1);

namespace Partitura\Resolver;

use Partitura\Locator\RequestDtoFactoryLocator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Controller\ArgumentValueResolverInterface;
use Symfony\Component\HttpKernel\ControllerMetadata\ArgumentMetadata;

/**
 * Class RequestDtoResolver
 * @package Partitura\Resolver
 */
class RequestDtoResolver implements ArgumentValueResolverInterface
{
    /** @var RequestDtoFactoryLocator */
    protected $factoryLocator;

    public function __construct(RequestDtoFactoryLocator $factoryLocator)
    {
        $this->factoryLocator = $factoryLocator;
    }

    /** {@inheritDoc} */
    public function supports(Request $request, ArgumentMetadata $argument): bool
    {
        $dtoClassName = $argument->getType();

        return $dtoClassName !== null
            && $this->factoryLocator->getFactory($dtoClassName) !== null;
    }

    /** {@inheritDoc} */
    public function resolve(Request $request, ArgumentMetadata $argument): iterable
    {
        yield $this->factoryLocator->getFactory($argument->getType())
            ->createFromRequest($request);
    }
}
