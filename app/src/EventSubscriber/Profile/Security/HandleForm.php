<?php

declare(strict_types=1);

namespace Partitura\EventSubscriber\Profile\Security;

use Doctrine\Persistence\ManagerRegistry;
use Partitura\Dto\Form\Profile\Security\ChangePasswordRequestDto;
use Partitura\Dto\Form\Profile\Security\DropRememberMeTokensRequestDto;
use Partitura\Dto\Form\Profile\Security\EmptyRequestDto;
use Partitura\Entity\User;
use Partitura\Event\Form\Profile\SecurityHandlingProcessEvent;
use Partitura\Exception\ForbiddenAccessException;
use Partitura\Exception\PasswordUpgradeException;
use Partitura\Service\User\CurrentUserService;
use Partitura\Service\User\PasswordSettingService;
use Partitura\Service\User\RememberMeTokensDeletingService;
use Partitura\Service\User\UserSavingService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class HandleForm
 * @package Partitura\EventSubscriber\Profile\Security
 */
class HandleForm implements EventSubscriberInterface
{
    public function __construct(
        protected CurrentUserService $currentUserService,
        protected UserSavingService $userSavingService,
        protected PasswordSettingService $passwordSettingService,
        protected RememberMeTokensDeletingService $rememberMeTokensDeletingService,
        protected ManagerRegistry $registry
    ) {
    }

    /** {@inheritDoc} */
    public static function getSubscribedEvents() : array
    {
        return [SecurityHandlingProcessEvent::class => "handleEvent"];
    }

    /**
     * @param SecurityHandlingProcessEvent $event
     *
     * @throws ForbiddenAccessException
     */
    public function handleEvent(SecurityHandlingProcessEvent $event) : void
    {
        $requestDto = $event->getRequestDto();

        // Request not need to be processed.
        if ($requestDto instanceof EmptyRequestDto) {
            return;
        }

        $currentUser = $this->currentUserService->getCurrentUser();

        if ($currentUser === null) {
            throw new ForbiddenAccessException("Can't change security options if user is unauthorized.");
        }

        if ($requestDto instanceof ChangePasswordRequestDto) {
            $this->handlePasswordChanging($event, $currentUser);
        } elseif ($requestDto instanceof DropRememberMeTokensRequestDto) {
            $this->handleDropRememberMeTokens($event, $currentUser);
        }
    }

    /**
     * @param SecurityHandlingProcessEvent $event
     * @param User $currentUser
     *
     * @throws PasswordUpgradeException
     */
    public function handlePasswordChanging(
        SecurityHandlingProcessEvent $event,
        User $currentUser
    ) : void {
        /** @var ChangePasswordRequestDto $requestDto */
        $requestDto = $event->getRequestDto();

        $this->passwordSettingService->setNewPassword(
            $currentUser,
            $requestDto->getNewPassword()
        );

        $this->rememberMeTokensDeletingService->clearAllUserTokens($currentUser);

        $this->userSavingService->saveUser($currentUser, true);

        $event->setResponseParameter("message", "Password changed successfully! All remember-me tokens was removed.");
    }

    /**
     * @param SecurityHandlingProcessEvent $event
     * @param User $currentUser
     */
    public function handleDropRememberMeTokens(
        SecurityHandlingProcessEvent $event,
        User $currentUser
    ) : void {
        $this->rememberMeTokensDeletingService->clearAllUserTokens($currentUser);

        $this->registry->getManager()->flush();

        $event->setResponseParameter("message", "Tokens was removed successfully!");
    }
}
