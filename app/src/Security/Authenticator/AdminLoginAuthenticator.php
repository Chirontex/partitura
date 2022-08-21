<?php
declare(strict_types=1);

namespace Partitura\Security\Authenticator;

use Doctrine\Persistence\ManagerRegistry;
use Partitura\Controller\Admin\LoginController;
use Partitura\Entity\User;
use Partitura\Enum\RoleEnum;
use Partitura\Exception\AuthenticationException;
use Partitura\Exception\EntityNotFoundException;
use Partitura\Factory\AuthenticationDtoFactory;
use Partitura\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException as SymfonyAuthenticationException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\RememberMeBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;

/**
 * Class AdminLoginAuthenticator
 * @package Partitura\Security\Authenticator
 */
class AdminLoginAuthenticator extends AbstractAuthenticator
{
    /** @var AuthenticationDtoFactory */
    protected $authenticationDtoFactory;

    /** @var UserRepository */
    protected $userRepository;

    /** @var UserPasswordHasherInterface */
    protected $passwordHasher;

    public function __construct(
        AuthenticationDtoFactory $authenticationDtoFactory,
        ManagerRegistry $registry,
        UserPasswordHasherInterface $passwordHasher
    ) {
        $this->authenticationDtoFactory = $authenticationDtoFactory;
        $this->userRepository = $registry->getRepository(User::class);
        $this->passwordHasher = $passwordHasher;
    }

    /** {@inheritDoc} */
    public function supports(Request $request) : ?bool
    {
        return $request->attributes->get("_route") === LoginController::ROUTE_LOGIN;
    }

    /** {@inheritDoc} */
    public function authenticate(Request $request) : Passport
    {
        $authneticationDto = $this->authenticationDtoFactory->createAuthenticationDto($request);

        try {
            $userBadge = new UserBadge(
                $authneticationDto->getUsername(),
                function (string $username) : User {
                    return $this->userRepository->findByUsername($username);
                }
            );

            /** @var User */
            $user = $userBadge->getUser();
        } catch (EntityNotFoundException $e) {
            throw new AuthenticationException($e->getMessage(), 0, $e);
        }

        if (!in_array(RoleEnum::ROLE_EDITOR->value, $user->getRoles())) {
            throw new AuthenticationException("Access is forbidden for this user.");
        }

        if (!$this->passwordHasher->isPasswordValid($user, $authneticationDto->getPassword())) {
            throw new AuthenticationException("Incorrect password.");
        }

        $credentialsBadge = new PasswordCredentials($authneticationDto->getPassword());
        $credentialsBadge->markResolved();

        $passport = new Passport($userBadge, $credentialsBadge);

        if ($authneticationDto->isNeedToRemember()) {
            $passport->addBadge(new RememberMeBadge());
        }

        return $passport;
    }

    /** {@inheritDoc} */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName) : ?Response
    {
        // возвращаем null, чтобы обработка запроса продолжилась
        return null;
    }

    /** {@inheritDoc} */
    public function onAuthenticationFailure(Request $request, SymfonyAuthenticationException $exception) : ?Response
    {
        $request->attributes->set(Security::AUTHENTICATION_ERROR, $exception);

        // возвращаем null, чтобы обработка запроса продолжилась
        return null;
    }
}
