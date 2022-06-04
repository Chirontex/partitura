<?php
declare(strict_types=1);

namespace Partitura\Factory\RequestDto;

use Doctrine\Common\Collections\ArrayCollection;
use Partitura\Dto\Api\BlogRequestDto;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class BlogRequestDtoFactory
 * @package Partitura\Factory\RequestDto
 */
class BlogRequestDtoFactory extends AbstractRequestDtoFactory
{
    protected const LIMIT = "limit";
    protected const OFFSET = "offset";

    /** {@inheritDoc} */
    public static function getDtoClass() : string
    {
        return BlogRequestDto::class;
    }

    /** {@inheritDoc} */
    protected function prepareDataFromRequest(Request $request) : ArrayCollection
    {
        return new ArrayCollection([
            static::LIMIT => $request->get(static::LIMIT),
            static::OFFSET => $request->get(static::OFFSET),
        ]);
    }
}
