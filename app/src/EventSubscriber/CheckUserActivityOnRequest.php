<?php

declare(strict_types=1);

namespace Partitura\EventSubscriber;

use Partitura\Controller\Profile\BannedController;
use Partitura\Controller\Profile\LogoutController;
use Partitura\Entity\User;
use Partitura\EventSubscriber\Trait\RequestEventSubscriberTrait;
use Partitura\Kernel;
use Partitura\Service\User\CurrentUserService;
use Symfony\Bundle\FrameworkBundle\Routing\Router;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\RequestEvent;

/**
 * Class CheckUserActivityOnRequest.
 */
class CheckUserActivityOnRequest implements EventSubscriberInterface
{
    use RequestEventSubscriberTrait;

    protected Router $router;

    public function __construct(protected CurrentUserService $currentUserService)
    {
        $this->router = Kernel::getInstance()->getService("router");
    }

    /** {@inheritDoc} */
    public static function getSubscribedEvents(): array
    {
        return [
            "kernel.request" => ["handleChecking", 0],
        ];
    }

    public function handleChecking(RequestEvent $event): void
    {
        if (!$event->isMainRequest()) {
            return;
        }

        $request = $event->getRequest();

        if (!$this->isRequestAbleToCheck($request)) {
            return;
        }

        $user = $this->currentUserService->getCurrentUser();

        if (!($user instanceof User)) {
            return;
        }

        if ($user->isActive()) {
            return;
        }

        $event->setResponse(
            $this->isNeedJsonResponse($request)
                ? $this->createJsonResponse()
                : $this->createRedirectResponse()
        );
    }

    protected function isRequestAbleToCheck(Request $request): bool
    {
        $requestUri = $request->getRequestUri();
        $bannedUri = $this->getRouteUri(BannedController::ROUTE_BANNED);
        $logoutUri = $this->getRouteUri(LogoutController::ROUTE_LOGOUT);

        return $requestUri !== $bannedUri && $requestUri !== $logoutUri;
    }

    protected function getRouteUri(string $routeName): string
    {
        return $this->router->generate($routeName);
    }

    protected function createJsonResponse(): JsonResponse
    {
        return new JsonResponse(
            [
                "code" => "BANNED",
                "message" => "Ваша учётная запись была деактивирована.",
            ],
            403
        );
    }

    protected function createRedirectResponse(): RedirectResponse
    {
        return new RedirectResponse($this->getRouteUri(BannedController::ROUTE_BANNED));
    }
}
