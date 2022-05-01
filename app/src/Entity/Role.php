<?php
declare(strict_types=1);

namespace Partitura\Entity;

use Doctrine\ORM\Mapping as ORM;
use Partitura\Entity\Trait\HasIdTrait;
use Partitura\Repository\RoleRepository;

/**
 * Role entity.
 * @package Partitura\Entity
 * 
 * @ORM\Entity(repositoryClass=RoleRepository::class)
 * @ORM\Table(name=Role::TABLE_NAME)
 */
class Role
{
    use HasIdTrait;

    public const TABLE_NAME = "p_roles";

    /**
     * @var string
     * 
     * @ORM\Column(
     *     type="string",
     *     name="CODE",
     *     length=180,
     *     unique=true
     * )
     */
    protected $code;

    /**
     * @var string
     * 
     * @ORM\Column(
     *     type="string",
     *     name="NAME",
     *     length=180
     * )
     */
    protected $name;

    /**
     * @return string
     */
    public function getCode() : string
    {
        return (string)$this->code;
    }

    /**
     * @param string $code
     *
     * @return $this
     */
    public function setCode(string $code) : static
    {
        $this->code = $code;

        return $this;
    }

    /**
     * @return string
     */
    public function getName() : string
    {
        return (string)$this->name;
    }

    /**
     * @param string $name
     *
     * @return $this
     */
    public function setName(string $name) : static
    {
        $this->name = $name;

        return $this;
    }
}
