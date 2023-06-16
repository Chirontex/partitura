<?php

declare(strict_types=1);

namespace Partitura\Tests\Unit\Factory;

use Partitura\Dto\CreateUserDto;
use Partitura\Enum\RoleEnum;
use Partitura\Factory\UserFactory;
use Partitura\Tests\Builder\Factory\UserFactoryBuilder;
use Partitura\Tests\Traits\GeneratePasswordTrait;
use Partitura\Tests\Traits\GenerateUsernameTrait;
use Partitura\Tests\Unit\SymfonyUnitTemplate;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @internal
 *
 * @covers \Partitura\Factory\UserFactory
 */
final class UserFactoryTest extends SymfonyUnitTemplate
{
    use GeneratePasswordTrait;
    use GenerateUsernameTrait;

    protected UserFactory $userFactory;

    protected function _before(): void
    {
        parent::_before();

        $this->userFactory = (new UserFactoryBuilder(
            $this->symfony,
            $this
        ))->createUserFactory();
    }

    public function testCreateUser(): void
    {
        $roles = RoleEnum::cases();
        $createUserDto = (new CreateUserDto())
            ->setUsername($this->generateUsername())
            ->setPassword($this->generatePassword())
            ->setRole($roles[rand(0, count($roles) - 1)])
        ;
        $user = $this->userFactory->createUser($createUserDto);

        $this->assertEquals(
            $createUserDto->getUsername(),
            $user->getUsername()
        );
        $this->assertEquals(
            $createUserDto->getRole(),
            $user->getRole()->getCode()
        );
        $this->assertTrue($this->getPasswordHasher()->isPasswordValid(
            $user,
            $createUserDto->getPassword()
        ));
    }

    public function testCreateUserWithoutRole(): void
    {
        $createUserDto = (new CreateUserDto())
            ->setUsername($this->generateUsername())
            ->setPassword($this->generatePassword())
        ;
        $user = $this->userFactory->createUser($createUserDto);

        $this->assertEquals(
            $createUserDto->getUsername(),
            $user->getUsername()
        );
        $this->assertEquals(
            RoleEnum::ROLE_USER->value,
            $createUserDto->getRole()
        );
        $this->assertEquals(
            $createUserDto->getRole(),
            $user->getRole()->getCode()
        );
        $this->assertTrue($this->getPasswordHasher()->isPasswordValid(
            $user,
            $createUserDto->getPassword()
        ));
    }

    private function getPasswordHasher(): UserPasswordHasherInterface
    {
        return $this->symfony->_getContainer()->get(UserPasswordHasherInterface::class);
    }
}
