<?php

declare(strict_types=1);

namespace Partitura\Entity;

use Doctrine\ORM\Mapping as ORM;
use Partitura\Entity\Trait\HasIdTrait;
use Partitura\Repository\UserFieldValueRepository;

/**
 * Class UserFieldValue.
 */
#[ORM\Entity(repositoryClass: UserFieldValueRepository::class)]
#[ORM\Table(name: UserFieldValue::TABLE_NAME)]
class UserFieldValue
{
    use HasIdTrait;

    public const TABLE_NAME = "pt_user_fields_values";

    #[ORM\JoinColumn(
        name: 'USER_ID',
        referencedColumnName: 'ID',
        nullable: false
    )]
    #[ORM\ManyToOne(
        targetEntity: '\Partitura\Entity\User',
        fetch: 'EAGER',
        inversedBy: 'additionalFields'
    )]
    protected ?User $user = null;

    #[ORM\JoinColumn(
        name: 'FIELD_ID',
        referencedColumnName: 'ID',
        nullable: false
    )]
    #[ORM\ManyToOne(
        targetEntity: '\Partitura\Entity\UserField',
        inversedBy: 'values'
    )]
    protected ?UserField $userField = null;

    #[ORM\Column(
        type: 'text',
        name: 'VALUE'
    )]
    protected ?string $value = null;

    public function getUser(): User
    {
        return $this->user;
    }

    /**
     *
     * @return $this
     */
    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getField(): UserField
    {
        return $this->userField;
    }

    /**
     *
     * @return $this
     */
    public function setField(UserField $userField): static
    {
        $this->userField = $userField;

        return $this;
    }

    public function getValue(): string
    {
        return (string)$this->value;
    }

    /**
     *
     * @return $this
     */
    public function setValue(string $value): static
    {
        $this->value = $value;

        return $this;
    }
}
