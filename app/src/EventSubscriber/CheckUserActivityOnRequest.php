<?php
declare(strict_types=1);

namespace Partitura\EventSubscriber;

use Partitura\Entity\User;
use Partitura\Service\UserService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\RequestEvent;

/**
 * Class CheckUserActivityOnRequest
 * @package Partitura\EventSubscriber
 */
class CheckUserActivityOnRequest implements EventSubscriberInterface
{
    /** @var UserService */
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /** {@inheritDoc} */
    public static function getSubscribedEvents() : array
    {
        return [
            "kernel.request" => ["handleChecking", 33],
        ];
    }

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

        if ($request->headers->get("Accept") === "application/json") {
            // TODO json response
        } else {
            // TODO html response
        }
    }
}
