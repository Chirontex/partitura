<?php
declare(strict_types=1);

namespace Partitura\Exception;

use Throwable;

/**
 * Class SecurityRequestDtoCreationException
 * @package Partitura\Exception
 */
class SecurityRequestDtoCreationException extends ArgumentException
{
    /** @var array<string, string> */
    protected $errors = [];

    public function __construct(array $errors = [], int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct(
            $this->createMessageFromErrors($errors),
            $code,
            $previous
        );

        $this->errors = $errors;
    }

    /**
     * @return array<string, string>
     */
    public function getErrors() : array
    {
        return $this->errors;
    }

    /**
     * @param array<string, string> $errors
     * 
     * @return string
     */
    protected function createMessageFromErrors(array $errors) : string
    {
        $message = "";

        foreach ($errors as $dtoClass => $exceptionMessage) {
            if (!empty($message)) {
                $message .= " | ";
            }

            $message .= sprintf("%s: %s", $dtoClass, $exceptionMessage);
        }

        return $message;
    }
}
