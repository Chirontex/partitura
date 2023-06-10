<?php

declare(strict_types=1);

namespace Partitura\Tests\Unit\Factory;

use Codeception\Module\Symfony;
use Codeception\Test\Unit;
use Partitura\Dto\CreateUserDto;
use Partitura\Enum\RoleEnum;
use Partitura\Factory\UserFactory;
use Partitura\Tests\Builder\Factory\UserFactoryBuilder;
use Partitura\Tests\UnitTester;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

/**
 * @internal
 *
 * @covers \Partitura\Factory\UserFactory
 */
final class UserFactoryTest extends Unit
{
    protected UnitTester $tester;

    protected Symfony $symfony;

    protected UserFactory $userFactory;

    protected function _before(): void
    {
        $this->symfony->_before($this);

        $this->userFactory = (new UserFactoryBuilder(
            $this->symfony,
            $this
        ))->createUserFactory();
    }

    protected function _after(): void
    {
        $this->symfony->_after($this);
    }

    protected function _inject(Symfony $symfony): void
    {
        $this->symfony = $symfony;
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

    private function generateUsername(int $length = 10): string
    {
        return $this->generateString($length, range('a', 'z'));
    }

    private function generatePassword(int $length = 10): string
    {
        return $this->generateString(
            $length,
            array_merge(range('a', 'z'), range(0, 9))
        );
    }

    private function generateString(int $length, array $chars): string
    {
        $string = [];

        for ($i = 0; $i < $length; ++$i) {
            $string[] = $chars[rand(0, count($chars) - 1)];
        }

        return implode('', $string);
    }

    private function getPasswordHasher(): UserPasswordHasherInterface
    {
        return $this->symfony->_getContainer()->get(UserPasswordHasherInterface::class);
    }
}
