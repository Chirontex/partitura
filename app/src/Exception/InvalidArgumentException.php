<?php

namespace Partitura\Exception;

use InvalidArgumentException as BaseException;
use Partitura\Interfaces\PartituraExceptionInterface;

/**
 * Class InvalidArgumentException
 * @package Partitura\Exception
 */
class InvalidArgumentException extends BaseException implements PartituraExceptionInterface
{
}
