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

        $user = $this->userService->getCurrentUser();

        if (!($user instanceof User)) {
            return;
        }

        if ($user->isActive()) {
            return;
        }

        $request = $event->getRequest();
        $response = $request->headers->get("Accept") === "application/json"
            ? $this->createJsonResponse()
            : $this->createRedirectResponse($request);

        if ($response !== null) {
            $event->setResponse($response);
        }
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
     * @param Request $request
     *
     * @return null|RedirectResponse
     */
    protected function createRedirectResponse(Request $request) : ?RedirectResponse
    {
        $redirectUri = $this->router->generate(BannedController::ROUTE_BANNED);
        $requestUri = $request->getRequestUri();

        return $requestUri === $redirectUri || $requestUri === $this->router->generate(LogoutController::ROUTE_LOGOUT)
            ? null
            : new RedirectResponse($redirectUri);
    }
}
