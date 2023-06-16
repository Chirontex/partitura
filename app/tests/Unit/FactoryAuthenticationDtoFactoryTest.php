<?php

declare(strict_types=1);

namespace Partitura\Tests\Unit;

use Partitura\Exception\AuthenticationException;
use Partitura\Factory\AuthenticationDtoFactory;
use Partitura\Tests\Traits\GeneratePasswordTrait;
use Partitura\Tests\Traits\GenerateUsernameTrait;
use Partitura\Tests\Unit\SymfonyUnitTemplate;
use Symfony\Component\HttpFoundation\Request;

/**
 * @internal
 *
 * $covers \Partitura\Factory\AuthenticationDtoFactory
 */
final class FactoryAuthenticationDtoFactoryTest extends SymfonyUnitTemplate
{
    use GeneratePasswordTrait;
    use GenerateUsernameTrait;

    protected AuthenticationDtoFactory $authenticationDtoFactory;

    protected function _before(): void
    {
        parent::_before();

        $this->authenticationDtoFactory = new AuthenticationDtoFactory();
    }

    public function testCreateAuthenticationDto(): void
    {
        $username = $this->generateUsername();
        $password = $this->generatePassword();
        $request = new Request(request: [
            '_username' => $username,
            '_password' => $password,
        ]);

        $authenticationDto = $this->authenticationDtoFactory->createAuthenticationDto($request);

        $this->assertEquals($username, $authenticationDto->getUsername());
        $this->assertEquals($password, $authenticationDto->getPassword());
    }

    public function testCreateAuthenticationDtoWithEmptyUsername(): void
    {
        $password = $this->generatePassword();
        $request = new Request(request: ['_password' => $password]);

        $this->expectException(AuthenticationException::class);

        $this->authenticationDtoFactory->createAuthenticationDto($request);
    }

    public function testCreateAuthenticationDtoWithEmptyPassword(): void
    {
        $username = $this->generateUsername();
        $request = new Request(request: ['_username' => $username]);

        $this->expectException(AuthenticationException::class);

        $this->authenticationDtoFactory->createAuthenticationDto($request);
    }

    public function testCreateAuthenticationDtoWithEmptyUsernameAndPassword(): void
    {
        $this->expectException(AuthenticationException::class);

        $this->authenticationDtoFactory->createAuthenticationDto(new Request());
    }
}
