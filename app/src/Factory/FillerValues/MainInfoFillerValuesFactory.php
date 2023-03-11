<?php

declare(strict_types=1);

namespace Partitura\Factory\FillerValues;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\ArrayTransformerInterface;
use Partitura\Exception\ForbiddenAccessException;
use Partitura\Factory\SettingsDtoFactory;
use Partitura\Service\User\CurrentUserService;
use Partitura\Service\User\UserFieldValuesGettingService;

/**
 * Class MainInfoFillerValuesFactory
 * @package Partitura\Factory\FillerValues
 */
class MainInfoFillerValuesFactory extends ProfileFillerValuesFactory
{
    public function __construct(
        SettingsDtoFactory $settingsDtoFactory,
        ArrayTransformerInterface $arrayTransformer,
        protected CurrentUserService $currentUserService,
        protected UserFieldValuesGettingService $userFieldValuesGettingService
    ) {
        parent::__construct($settingsDtoFactory, $arrayTransformer);
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

        return new ArrayCollection(array_merge(
            $this->userFieldValuesGettingService->getValuesWithEmpty($currentUser)->toArray(),
            parent::getFillerValuesCollection()->toArray()
        ));
    }

    /** {@inheritDoc} */
    public static function getView() : string
    {
        return "genesis/profile/main_info.html.twig";
    }
}
