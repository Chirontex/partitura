<?php

declare(strict_types=1);

namespace Partitura\Filler;

use Doctrine\Common\Collections\ArrayCollection;
use Partitura\Exception\ForbiddenAccessException;
use Partitura\Service\User\CurrentUserService;
use Partitura\Service\User\UserFieldValuesGettingService;

/**
 * Class UserFieldValuesFiller
 * @package Partitura\Filler
 */
class UserFieldValuesFiller
{
    public function __construct(
        protected CurrentUserService $currentUserService,
        protected UserFieldValuesGettingService $userFieldValuesGettingService
    ) {
    }

    /**
     * @return ArrayCollection<string, string>
     */
    public function fillUserFieldValues() : ArrayCollection
    {
        $currentUser = $this->currentUserService->getCurrentUser();

        if ($currentUser === null) {
            throw new ForbiddenAccessException("Unauthorized access is forbidden.");
        }

        return $this->userFieldValuesGettingService->getValuesWithEmpty($currentUser);
    }
}
