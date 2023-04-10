<?php

namespace Partitura\Exception;

use InvalidArgumentException as BaseException;
use Partitura\Interfaces\PartituraExceptionInterface;

/**
 * Class InvalidArgumentException
 */
class InvalidArgumentException extends BaseException implements PartituraExceptionInterface
{
}
