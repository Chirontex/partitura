<?php

declare(strict_types=1);

namespace Partitura\Tests\Unit\Builder\Factory;

use Codeception\Module\Symfony;
use Codeception\Test\Unit;
use Partitura\Entity\Role;
use Partitura\Factory\UserFactory;
use Partitura\Repository\RoleRepository;
use Partitura\Service\User\PasswordSettingService;
use Partitura\Tests\Unit\Builder\Registry\MockManagerRegistryBuilder;

class UserFactoryBuilder
{
    public function __construct(
        protected Symfony $symfony,
        protected Unit $codeception
    ) {
    }

    public function createUserFactory(): UserFactory
    {
        $mockManagerRegistry = (new MockManagerRegistryBuilder($this->codeception))
            ->createMockManagerRegistry(function () {
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
