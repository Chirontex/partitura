<?php

declare(strict_types=1);

namespace Partitura\Tests\Unit\Mock;

use Partitura\Entity\User;
use Partitura\Service\User\CurrentUserService as BaseCurrentUserService;

class CurrentUserService extends BaseCurrentUserService
{
    protected ?User $user = null;

    public function __construct()
    {
    }

    /** {@inheritDoc} */
    public function getCurrentUser(): ?User
    {
        return $this->user;
    }

    /**
     * @return $this
     */
    public function setCurrentUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }
}
