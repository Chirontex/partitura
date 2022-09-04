<?php
declare(strict_types=1);

namespace Partitura\Controller;

use Partitura\Dto\SettingsDto;

/**
 * Class AbstractLoginController
 * @package Partitura\Controller
 */
abstract class AbstractLoginController extends Controller
{
    /** {@inheritDoc} */
    protected function createSettingsDto() : SettingsDto
    {
        return $this->getSettingsDtoFactory()->createDtoForLoginForm($this->getActionRoute());
    }

    /**
     * @return string
     */
    abstract protected function getActionRoute() : string;
}

