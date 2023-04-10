<?php

declare(strict_types=1);

namespace Partitura\Factory\FillerValues;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\ArrayTransformerInterface;
use Partitura\Controller\Profile\ProfileController;
use Partitura\Dto\SettingsDto;
use Partitura\Factory\SettingsDtoFactory;
use Partitura\Interfaces\FillerValuesFactoryInterface;

/**
 * Class ProfileFillerValuesFactory
 */
abstract class ProfileFillerValuesFactory implements FillerValuesFactoryInterface
{
    public function __construct(
        protected SettingsDtoFactory $settingsDtoFactory,
        protected ArrayTransformerInterface $arrayTransformer
    ) {
    }

    /** {@inheritDoc} */
    public function getFillerValuesCollection(): ArrayCollection
    {
        return new ArrayCollection(
            $this->arrayTransformer->toArray($this->createSettingsDto())
        );
    }

    protected function createSettingsDto(): SettingsDto
    {
        $settingsDto = $this->settingsDtoFactory->createDto();

        ProfileController::completeSettingsDto($settingsDto);

        return $settingsDto;
    }
}
