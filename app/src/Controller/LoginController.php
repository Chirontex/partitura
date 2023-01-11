<?php
declare(strict_types=1);

namespace Partitura\Controller;

use Partitura\Interfaces\ViewResolverInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class LoginController
 * @package Partitura\Controller
 * 
 * @Route("/login")
 */
class LoginController extends AbstractLoginController
{
    public const ROUTE_LOGIN = "partitura_login";
    
    public const LOGIN_CSRF_TOKEN_ID = "login";

    protected ViewResolverInterface $viewResolver;

    public function __construct(ViewResolverInterface $viewResolver)
    {
        $this->viewResolver = $viewResolver;
    }

    /**
     * @param AuthenticationUtils $authenticationUtils
     * 
     * @return Response
     * 
     * @Route("/", name=LoginController::ROUTE_LOGIN, methods={"GET", "POST"})
     */
    public function login(AuthenticationUtils $authenticationUtils) : Response
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
                "csrf_token_id" => static::LOGIN_CSRF_TOKEN_ID,
            ]
        );
    }

    /** {@inheritDoc} */
    protected function getActionRoute() : string
    {
        return static::ROUTE_LOGIN;
    }
}
