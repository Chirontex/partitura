<?php

declare(strict_types=1);

namespace Partitura\Tests\Unit\Builder\Registry;

use Codeception\Test\Unit;
use Doctrine\Persistence\AbstractManagerRegistry;
use PHPUnit\Framework\MockObject\MockObject;

class MockManagerRegistryBuilder
{
    public function __construct(protected Unit $codeception)
    {
    }

    /**
     * @return AbstractManagerRegistry|MockObject
     */
    public function createMockManagerRegistry(
        callable $getRepositoryCallback
    ): AbstractManagerRegistry {
        /** @var AbstractManagerRegistry|MockObject $mockManagerRegistry */
        $mockManagerRegistry = $this->codeception->getMockBuilder(AbstractManagerRegistry::class)
            ->onlyMethods(['getRepository'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass()
        ;

        $mockManagerRegistry
            ->method('getRepository')
            ->willReturnCallback($getRepositoryCallback)
        ;

        return $mockManagerRegistry;
    }
}
