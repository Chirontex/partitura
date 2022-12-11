<?php
declare(strict_types=1);

namespace Partitura\Exception;

use Throwable;

/**
 * Class ArgumentException
 * @package Partitura\Exception
 */
class ArgumentException extends LogicException
{
    /** @var string[] */
    protected array $errorMessages = [];

    public function __construct(
        array $errorMessages = [],
        int $code = 0,
        ?Throwable $previous = null
    ) {
        parent::__construct(implode(" ", $errorMessages), $code, $previous);

        $this->errorMessages = $errorMessages;
    }

    /**
     * @return string[]
     */
    public function getErrorMessages() : array
    {
        return $this->errorMessages;
    }
}
