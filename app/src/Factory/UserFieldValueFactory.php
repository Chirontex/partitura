<?php

declare(strict_types=1);

namespace Partitura\Factory;

use Partitura\Entity\User;
use Partitura\Entity\UserField;
use Partitura\Entity\UserFieldValue;

/**
 * Class UserFieldValueFactory.
 */
class UserFieldValueFactory
{
    public function create(UserField $userField, User $user, string $value): UserFieldValue
    {
        return (new UserFieldValue())
            ->setField($userField)
            ->setUser($user)
            ->setValue($value);
    }
}
