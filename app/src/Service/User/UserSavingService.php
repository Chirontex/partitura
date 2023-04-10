<?php

declare(strict_types=1);

namespace Partitura\Service\User;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManagerInterface;
use Partitura\Entity\User;
use Partitura\Event\UserSaving\AfterAddEvent;
use Partitura\Event\UserSaving\AfterUpdateEvent;
use Partitura\Event\UserSaving\BeforeAddEvent;
use Partitura\Event\UserSaving\BeforeUpdateEvent;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class UserSavingService
 */
class UserSavingService
{
    /** @var ArrayCollection<User> */
    protected ArrayCollection $newUsers;

    /** @var ArrayCollection<User> */
    protected ArrayCollection $updatedUsers;

    public function __construct(
        protected EntityManagerInterface $entityManager,
        protected EventDispatcherInterface $eventDispatcher
    ) {
        $this->initializeCollections();
    }

    /**
     * @param bool $flush Warning: previously given users and other entities under EntityManager control will be flushed too!
     */
    public function saveUser(User $user, bool $flush = false): void
    {
        $user->getId() === 0 ? $this->add($user) : $this->update($user);

        if ($flush) {
            $this->flush();
        }
    }

    /**
     * Applies all changes in users to database.
     * Warning: all changes in other entities will be flushed too!
     */
    public function flush(): void
    {
        $this->entityManager->flush();

        /**
         * @param ArrayCollection<User> $userCollection
         * @param string $eventClass
         */
        $dispatchEventsFn = function (ArrayCollection $userCollection, string $eventClass): void {
            foreach ($userCollection as $user) {
                $this->eventDispatcher->dispatch(new $eventClass($user));
            }
        };

        $dispatchEventsFn($this->newUsers, AfterAddEvent::class);
        $dispatchEventsFn($this->updatedUsers, AfterUpdateEvent::class);

        $this->initializeCollections();
    }

    protected function add(User $user): void
    {
        $this->entityManager->persist($user);

        $this->newUsers->add($user);
        $this->eventDispatcher->dispatch(new BeforeAddEvent($user));
    }

    protected function update(User $user): void
    {
        $user->setDatetimeUpdated(new DateTime());

        $this->updatedUsers->add($user);
        $this->eventDispatcher->dispatch(new BeforeUpdateEvent($user));
    }

    protected function initializeCollections(): void
    {
        $this->newUsers = new ArrayCollection();
        $this->updatedUsers = new ArrayCollection();
    }
}
