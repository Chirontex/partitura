<?php
declare(strict_types=1);

namespace Partitura\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Partitura\Entity\Trait\HasCodeTrait;
use Partitura\Entity\Trait\HasIdTrait;
use Partitura\Repository\UserFieldRepository;

/**
 * Class UserField
 * @package Partitura\Entity
 */
#[ORM\Entity(repositoryClass: UserFieldRepository::class)]
#[ORM\Table(name: UserField::TABLE_NAME)]
class UserField
{
    use HasIdTrait,
        HasCodeTrait;

    public const TABLE_NAME = "pt_user_fields";

    #[ORM\OneToMany(
        targetEntity: '\Partitura\Entity\UserFieldValue',
        mappedBy: 'userField'
    )]    
    protected ?PersistentCollection $values = null;

    /**
     * @return null|PersistentCollection<UserFieldValue>
     */
    public function getValues() : ?PersistentCollection
    {
        return $this->values;
    }

    /**
     * @param int $userId
     *
     * @return null|UserFieldValue
     */
    public function findValueByUserId(int $userId) : ?UserFieldValue
    {
        foreach ($this->getValues() as $userFieldValue) {
            if ($userFieldValue->getUser()->getId() === $userId) {
                return $userFieldValue;
            }
        }

        return null;
    }
}
