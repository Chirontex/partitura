<?php

declare(strict_types=1);

namespace Partitura\Tests\Builder\Factory;

use Codeception\Module\Symfony;
use Codeception\Test\Unit;
use Doctrine\Persistence\AbstractManagerRegistry;
use Partitura\Entity\Role;
use Partitura\Factory\UserFactory;
use Partitura\Repository\RoleRepository;
use Partitura\Service\User\PasswordSettingService;
use PHPUnit\Framework\MockObject\MockObject;

class UserFactoryBuilder
{
    public function __construct(
        protected Symfony $symfony,
        protected Unit $codeception
    ) {
    }

    public function createUserFactory(): UserFactory
    {
        /** @var AbstractManagerRegistry|MockObject $mockManagerRegistry */
        $mockManagerRegistry = $this->codeception->getMockBuilder(AbstractManagerRegistry::class)
            ->onlyMethods(['getRepository'])
            ->disableOriginalConstructor()
            ->getMockForAbstractClass()
        ;

        $mockManagerRegistry
            ->method('getRepository')
            ->willReturnCallback(function () {
                return $this->codeception->make(
                    RoleRepository::class,
                    [
                        'findByCode' => static function (string $roleCode): Role {
                            return (new Role())->setCode($roleCode);
                        },
                    ]
                );
            })
        ;

        return new UserFactory(
            $mockManagerRegistry,
            $this->symfony->_getContainer()->get(PasswordSettingService::class)
        );
    }
}
