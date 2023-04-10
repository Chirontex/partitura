<?php

namespace Partitura\Exception;

use Partitura\Interfaces\PartituraExceptionInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

/**
 * Class PasswordUpgradeException
 */
class PasswordUpgradeException extends UnsupportedUserException implements PartituraExceptionInterface
{
}
