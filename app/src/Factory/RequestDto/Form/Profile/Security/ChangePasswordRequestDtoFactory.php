<?php
declare(strict_types=1);

namespace Partitura\Factory\RequestDto\Form\Profile\Security;

use Partitura\Dto\Form\Profile\Security\ChangePasswordRequestDto;
use Partitura\Factory\RequestDto\AbstractRequestDtoFactory;

/**
 * Class ChangePasswordRequestDtoFactory
 * @package Partitura\Factory\RequestDto\Form\Profile\Security
 */
class ChangePasswordRequestDtoFactory extends AbstractRequestDtoFactory
{
    /** {@inheritDoc} */
    public static function getDtoClass() : string
    {
        return ChangePasswordRequestDto::class;
    }
}
