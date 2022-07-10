<?php
declare(strict_types=1);

namespace Partitura\Enum;

use Partitura\Enum\Traits\GetInstanceByValueTrait;

/**
 * @package Partitura\Enum
 */
enum PostTypeEnum : string
{
    use GetInstanceByValueTrait;

    case PUBLISHED = "published";
    case DRAFT = "draft";
    case TRASH = "trash";
}
