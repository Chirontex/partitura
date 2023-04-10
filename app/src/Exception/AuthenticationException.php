<?php

declare(strict_types=1);

namespace Partitura\Exception;

use Partitura\Interfaces\PartituraExceptionInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException as SymfonyAuthenticationException;

/**
 * Class AuthenticationException.
 */
class AuthenticationException extends SymfonyAuthenticationException implements PartituraExceptionInterface
{
    /** {@inheritDoc} */
    public function getMessageKey(): string
    {
        // TODO: реализовать перевод сообщений
        return $this->getMessage();
    }
}
