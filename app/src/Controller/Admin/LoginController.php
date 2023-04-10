<?php

declare(strict_types=1);

namespace Partitura\Controller\Admin;

use Partitura\Controller\AbstractLoginController;
use Partitura\Entity\User;
use Partitura\Enum\RoleEnum;
use Partitura\Exception\ForbiddenAccessException;
use Partitura\Interfaces\CsrfTokenIdResolverInterface;
use Partitura\Interfaces\ViewResolverInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class LoginController.
 *
 * @Route("/admin/login")
 */
class LoginController extends AbstractLoginController
{
    public const ROUTE_LOGIN = "partitura_admin_login";

    public function __construct(
        protected ViewResolverInterface $viewResolver,
        protected CsrfTokenIdResolverInterface $csrfTokenIdResolver
    ) {
    }

    /**
     *
     *
     * @Route("/", name=LoginController::ROUTE_LOGIN, methods={"GET", "POST"})
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        /** @var null|User */
        $user = $this->getUser();

        if ($user !== null && $user->hasRole(RoleEnum::ROLE_EDITOR)) {
            return $this->redirectToRoute(DashboardController::ROUTE_DASHBOARD);
        }

        $error = $user !== null
            ? new ForbiddenAccessException()
            : $authenticationUtils->getLastAuthenticationError();

        return $this->render(
            $this->viewResolver->resolveViewByRoute(static::ROUTE_LOGIN),
            [
                "route_name" => static::ROUTE_LOGIN,
                "last_username" => $authenticationUtils->getLastUsername(),
                "error" => $error,
                "csrf_token_id" => $this->csrfTokenIdResolver->resolveCsrfTokenIdByRouteName(static::ROUTE_LOGIN),
            ]
        );
    }

    /** {@inheritDoc} */
    protected function getActionRoute(): string
    {
        return static::ROUTE_LOGIN;
    }
}
