<?php
declare(strict_types=1);

namespace Partitura\Entity;

use Doctrine\ORM\Mapping as ORM;
use Partitura\Entity\Trait\HasCodeTrait;
use Partitura\Entity\Trait\HasIdTrait;
use Partitura\Repository\UserFieldRepository;

/**
 * Class UserField
 * @package Partitura\Entity
 * 
 * @ORM\Entity(repositoryClass=UserFieldRepository::class)
 * @ORM\Table(name=UserField::TABLE_NAME)
 */
class UserField
{
    use HasIdTrait,
        HasCodeTrait;

    public const TABLE_NAME = "pt_user_fields";
}
