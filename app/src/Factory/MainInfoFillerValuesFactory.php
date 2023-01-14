<?php

declare(strict_types=1);

namespace Partitura\Factory;

use Doctrine\Common\Collections\ArrayCollection;
use Partitura\Exception\ForbiddenAccessException;
use Partitura\Interfaces\FillerValuesFactoryInterface;
use Partitura\Service\User\CurrentUserService;
use Partitura\Service\User\UserFieldValuesGettingService;

/**
 * Class MainInfoFillerValuesFactory
 * @package Partitura\Factory
 */
class MainInfoFillerValuesFactory implements FillerValuesFactoryInterface
{
    public function __construct(
        protected CurrentUserService $currentUserService,
        protected UserFieldValuesGettingService $userFieldValuesGettingService
    ) {
    }

    /**
     * {@inheritDoc}
     *
     * @throws ForbiddenAccessException
     */
    public function getFillerValuesCollection(): ArrayCollection
    {
        $currentUser = $this->currentUserService->getCurrentUser();

        if ($currentUser === null) {
            throw new ForbiddenAccessException("Unauthorized access is forbidden.");
        }

        return $this->userFieldValuesGettingService->getValuesWithEmpty($currentUser);
    }

    /** {@inheritDoc} */
    public static function getView() : string
    {
        return "genesis/profile/main_info.html.twig";
    }
}
