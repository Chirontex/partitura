<?php

declare(strict_types=1);

namespace Partitura\Enum;

use Doctrine\Common\Collections\ArrayCollection;
use Partitura\Enum\Trait\GetInstanceByValueTrait;
use Partitura\Kernel;

/**
 * Enum RoleEnum.
 */
enum RoleEnum: string
{
    use GetInstanceByValueTrait;

    case ROLE_USER = "ROLE_USER";
    case ROLE_EDITOR = "ROLE_EDITOR";
    case ROLE_MODERATOR = "ROLE_MODERATOR";
    case ROLE_ADMIN = "ROLE_ADMIN";
    case ROLE_ROOT = "ROLE_ROOT";

    public function getName(): string
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
     * @return self[]
     */
    public function getParents(): array
    {
        /** @var ArrayCollection<string, string[]> */
        $roleHierarchy = new ArrayCollection(
            Kernel::getInstance()->getParameter("security.role_hierarchy.roles")
        );

        if (!$roleHierarchy->containsKey($this->value)) {
            return [];
        }

        $parents = [];

        foreach ($roleHierarchy->get($this->value) as $roleEnumValue) {
            $parents[] = self::getInstanceByValue($roleEnumValue);
        }

        return $parents;
    }
}
