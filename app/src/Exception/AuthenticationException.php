<?php
declare(strict_types=1);

namespace Partitura\Exception;

use Partitura\Interfaces\PartituraExceptionInterface;
use Symfony\Component\Security\Core\Exception\AuthenticationException as SymfonyAuthenticationException;

/**
 * Class AuthenticationException
 * @package Partitura\Exception
 */
class AuthenticationException extends SymfonyAuthenticationException implements PartituraExceptionInterface
{
}
