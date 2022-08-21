<?php
declare(strict_types=1);

namespace Partitura\Enum;

use Partitura\Enum\Trait\GetInstanceByValueTrait;

/**
 * Enum RoleEnum
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

    /**
     * @return null|self
     */
    public function getParent() : ?self
    {
        return match ($this) {
            self::ROLE_USER => null,
            self::ROLE_EDITOR => self::ROLE_USER,
            self::ROLE_MODERATOR => self::ROLE_EDITOR,
            self::ROLE_ADMIN => self::ROLE_MODERATOR,
            self::ROLE_ROOT => self::ROLE_ADMIN,
        };
    }
}
