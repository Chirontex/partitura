<?php
declare(strict_types=1);

namespace Partitura\Security\Authenticator;

use Partitura\Controller\Admin\DashboardController;
use Partitura\Controller\Admin\LoginController;
use Partitura\Entity\User;
use Partitura\Enum\RoleEnum;
use Partitura\Event\AdminLogin\BeforePasswordValidationEvent;
use Partitura\Exception\AuthenticationException;
use Partitura\Exception\ForbiddenAccessException;
use Partitura\Exception\SkipAuthenticationException;
use Partitura\Factory\AuthenticationDtoFactory;
use Partitura\Factory\UserBadgeFactory;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException as SymfonyAuthenticationException;
use Symfony\Component\Security\Core\Exception\LogicException;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use Symfony\Component\Security\Http\Authenticator\AbstractAuthenticator;
use Symfony\Component\Security\Http\Authenticator\Passport\Credentials\PasswordCredentials;
use Symfony\Component\Security\Http\Authenticator\Passport\Passport;
use Throwable;

/**
 * Class AdminLoginAuthenticator
 * @package Partitura\Security\Authenticator
 */
class AdminLoginAuthenticator extends AbstractAuthenticator
{
    /** @var AuthenticationDtoFactory */
    protected $authenticationDtoFactory;

    /** @var UserPasswordHasherInterface */
    protected $passwordHasher;

    /** @var UserBadgeFactory */
    protected $userBadgeFactory;

    /** @var EventDispatcherInterface */
    protected $eventDispatcher;

    /** @var CsrfTokenManagerInterface */
    protected $csrfTokenManager;

    /** @var RouterInterface */
    protected $router;

    public function __construct(
        AuthenticationDtoFactory $authenticationDtoFactory,
        UserPasswordHasherInterface $passwordHasher,
        UserBadgeFactory $userBadgeFactory,
        EventDispatcherInterface $eventDispatcher,
        CsrfTokenManagerInterface $csrfTokenManager,
        RouterInterface $router
    ) {
        $this->authenticationDtoFactory = $authenticationDtoFactory;
        $this->passwordHasher = $passwordHasher;
        $this->userBadgeFactory = $userBadgeFactory;
        $this->eventDispatcher = $eventDispatcher;
        $this->csrfTokenManager = $csrfTokenManager;
        $this->router = $router;
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
        $userBadge = $this->userBadgeFactory->createUserBadge($authneticationDto);

        if (!$this->csrfTokenManager->isTokenValid(new CsrfToken(
            LoginController::CSRF_TOKEN_ID,
            $request->get("_csrf_token")
        ))) {
            throw new AuthenticationException("Invalid CSRF token.");
        }

        /** @var User */
        $user = $userBadge->getUser();
        $credentialsBadge = new PasswordCredentials($authneticationDto->getPassword());

        try {
            $this->eventDispatcher->dispatch(new BeforePasswordValidationEvent($user, $credentialsBadge));
        } catch (Throwable $e) {
            $e instanceof AuthenticationException
                ? throw $e
                : throw new AuthenticationException($e->getMessage(), 0, $e);
        }

        try {
            if (!$this->passwordHasher->isPasswordValid($user, $credentialsBadge->getPassword())) {
                throw new AuthenticationException("Incorrect password.");
            }
        } catch (LogicException) {
            // считаем, что пароль уже был провалидирован
        }

        if (!$credentialsBadge->isResolved()) {
            $credentialsBadge->markResolved();
        }

        if (!$user->hasRole(RoleEnum::ROLE_EDITOR)) {
            throw new ForbiddenAccessException();
        }

        return (new Passport($userBadge, $credentialsBadge));
    }

    /** {@inheritDoc} */
    public function onAuthenticationSuccess(Request $request, TokenInterface $token, string $firewallName) : ?Response
    {
        return new RedirectResponse($this->router->generate(DashboardController::ROUTE_DASHBOARD));
    }

    /** {@inheritDoc} */
    public function onAuthenticationFailure(Request $request, SymfonyAuthenticationException $exception) : ?Response
    {
        if ((!$exception instanceof SkipAuthenticationException)) {
            $request->attributes->set(Security::AUTHENTICATION_ERROR, $exception);
        }

        // возвращаем null, чтобы обработка запроса продолжилась
        return null;
    }
}
