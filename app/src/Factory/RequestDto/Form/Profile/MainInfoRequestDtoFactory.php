<?php
declare(strict_types=1);

namespace Partitura\Factory\RequestDto\Form\Profile;

use Partitura\Dto\Form\Profile\MainInfoRequestDto;
use Partitura\Factory\RequestDto\AbstractRequestDtoFactory;

/**
 * Class MainInfoRequestDtoFactory
 * @package Partitura\Factory\RequestDto\Form\Profile
 */
class MainInfoRequestDtoFactory extends AbstractRequestDtoFactory
{
    /** {@inheritDoc} */
    public static function getDtoClass() : string
    {
        return MainInfoRequestDto::class;
    }
}
