<?php
declare(strict_types=1);

namespace Partitura\Dto\Form\Profile\Security;

use Partitura\Controller\Profile\ProfileController;
use Partitura\Dto\Form\AbstractFormRequestDto;

/**
 * Class SecurityRequestDto
 * @package Partitura\Dto\Form\Profile\Security
 */
abstract class SecurityRequestDto extends AbstractFormRequestDto
{
    /** {@inheritDoc} */
    public function getCsrfTokenId() : string
    {
        return ProfileController::SECURITY_CSRF_TOKEN_ID;
    }
}
