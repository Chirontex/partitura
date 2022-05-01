<?php

namespace Partitura\Exception;

use Partitura\Interfaces\PartituraExceptionInterface;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

/**
 * Class PasswordUpgradeException
 * @package Partitura\Exception
 */
class PasswordUpgradeException extends UnsupportedUserException implements PartituraExceptionInterface
{
}
