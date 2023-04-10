<?php

declare(strict_types=1);

namespace Partitura\Exception;

use Throwable;

/**
 * Class PostsLoaderAlreadyLoadedException
 */
class PostsLoaderAlreadyLoadedException extends SystemException
{
    public function __construct(
        string $message = "PostsLoader already loaded.",
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct($message, $code, $previous);
    }
}
