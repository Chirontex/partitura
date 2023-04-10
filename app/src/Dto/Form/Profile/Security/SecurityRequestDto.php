<?php

declare(strict_types=1);

namespace Partitura\Dto\Form\Profile\Security;

use Partitura\Controller\Profile\ProfileController;
use Partitura\Dto\Form\AbstractFormRequestDto;

/**
 * Class SecurityRequestDto
 */
abstract class SecurityRequestDto extends AbstractFormRequestDto
{
    /** {@inheritDoc} */
    public function getRouteName(): string
    {
        return ProfileController::ROUTE_SECURITY;
    }
}
