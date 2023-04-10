<?php

declare(strict_types=1);

namespace Partitura\Controller;

use Partitura\Interfaces\CsrfTokenIdResolverInterface;
use Partitura\Interfaces\ViewResolverInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class LoginController
 *
 * @Route("/login")
 */
class LoginController extends AbstractLoginController
{
    public const ROUTE_LOGIN = "partitura_login";

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
        if ($this->getUser() !== null) {
            return $this->redirectToRoute(MainController::ROUTE_INDEX);
        }

        return $this->render(
            $this->viewResolver->resolveViewByRoute(static::ROUTE_LOGIN),
            [
                "route_name" => static::ROUTE_LOGIN,
                "last_username" => $authenticationUtils->getLastUsername(),
                "error" => $authenticationUtils->getLastAuthenticationError(),
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
