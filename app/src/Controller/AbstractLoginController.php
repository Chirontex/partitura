<?php

declare(strict_types=1);

namespace Partitura\Controller;

use Partitura\Dto\SettingsDto;

/**
 * Class AbstractLoginController.
 */
abstract class AbstractLoginController extends Controller
{
    /** {@inheritDoc} */
    protected function createSettingsDto(): SettingsDto
    {
        return $this->getSettingsDtoFactory()->createDtoForLoginForm($this->getActionRoute());
    }

    abstract protected function getActionRoute(): string;
}
