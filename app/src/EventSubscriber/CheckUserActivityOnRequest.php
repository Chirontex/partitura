<?php
declare(strict_types=1);

namespace Partitura\EventSubscriber;

use Partitura\Controller\Profile\BannedController;
use Partitura\Controller\Profile\LogoutController;
use Partitura\Entity\User;
use Partitura\Kernel;
use Partitura\Service\UserService;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;

/**
 * Class CheckUserActivityOnRequest
 * @package Partitura\EventSubscriber
 */
class CheckUserActivityOnRequest implements EventSubscriberInterface
{
    /** @var UserService */
    protected $userService;

    /** @var Router */
    protected $router;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
        $this->router = Kernel::getInstance()->getService("router");
    }

    /** {@inheritDoc} */
    public static function getSubscribedEvents() : array
    {
        return [
            "kernel.request" => ["handleChecking", 0],
        ];
    }

    /**
     * @param RequestEvent $event
     */
    public function handleChecking(RequestEvent $event) : void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();
        
        if (!$this->isRequestAbleToCheck($request)) {
            return;
        }

        $user = $this->userService->getCurrentUser();

        if (!($user instanceof User)) {
            return;
        }

        if ($user->isActive()) {
            return;
        }

        $event->setResponse(
            $request->headers->get("Accept") === "application/json"
                ? $this->createJsonResponse()
                : $this->createRedirectResponse()
        );
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    protected function isRequestAbleToCheck(Request $request) : bool
    {
        $requestUri = $request->getRequestUri();
        $bannedUri = $this->getRouteUri(BannedController::ROUTE_BANNED);
        $logoutUri = $this->getRouteUri(LogoutController::ROUTE_LOGOUT);

        return $requestUri !== $bannedUri && $requestUri !== $logoutUri;
    }

    /**
     * @param string $routeName
     * 
     * @return string
     */
    protected function getRouteUri(string $routeName) : string
    {
        return $this->router->generate($routeName);
    }

    /**
     * @return JsonResponse
     */
    protected function createJsonResponse() : JsonResponse
    {
        return new JsonResponse(
            [
                "code" => "BANNED",
                "message" => "Ваша учётная запись была деактивирована.",
            ],
            403
        );
    }

    /**
     * @return RedirectResponse
     */
    protected function createRedirectResponse() : RedirectResponse
    {
        return new RedirectResponse($this->getRouteUri(BannedController::ROUTE_BANNED));
    }
}
