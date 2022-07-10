<?php
declare(strict_types=1);

namespace Partitura\Enum;

use Partitura\Enum\Traits\GetInstanceByValueTrait;

/**
 * @package Partitura\Enum
 */
enum RoleEnum : string
{
    use GetInstanceByValueTrait;

    case ROLE_USER = "ROLE_USER";
    case ROLE_EDITOR = "ROLE_EDITOR";
    case ROLE_MODERATOR = "ROLE_MODERATOR";
    case ROLE_ADMIN = "ROLE_ADMIN";
    case ROLE_ROOT = "ROLE_ROOT";

    /**
     * @return string
     */
    public function getName() : string
    {
        return match ($this) {
            self::ROLE_USER => "Пользователь",
            self::ROLE_EDITOR => "Редактор",
            self::ROLE_MODERATOR => "Модератор",
            self::ROLE_ADMIN => "Администратор",
            self::ROLE_ROOT => "Суперадминистратор",
        };
    }
}
