<?php
declare(strict_types=1);

namespace Partitura\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
use Partitura\Entity\Trait\HasDatetimeCreatedTrait;
use Partitura\Entity\Trait\HasDatetimeUpdatedTrait;
use Partitura\Entity\Trait\HasIdTrait;
use Partitura\Exception\NotImplementedException;
use Partitura\Interfaces\PasswordUpgradableUserInterface;
use Partitura\Repository\UserRepository;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * User main entity.
 * @package Partitura\Entity
 * 
 * @ORM\Entity(repositoryClass=UserRepository::class)
 * @ORM\Table(name=User::TABLE_NAME)
 */
class User implements UserInterface, PasswordUpgradableUserInterface
{
    use HasIdTrait,
        HasDatetimeCreatedTrait,
        HasDatetimeUpdatedTrait;

    public const TABLE_NAME = "pt_users";

    /**
     * @var string
     * 
     * @ORM\Column(
     *     type="string",
     *     name="USERNAME",
     *     length=180,
     *     unique=true
     * )
     */
    protected $username;

    /**
     * @var Role
     * 
     * @ORM\JoinColumn(
     *     name="ROLE_ID",
     *     referencedColumnName="ID"
     * )
     * @ORM\ManyToOne(
     *     targetEntity="\Partitura\Entity\Role",
     *     fetch="EAGER",
     *     inversedBy="users"
     * )
     */
    protected $role;

    /**
     * @var string
     * 
     * @ORM\Column(
     *     type="string",
     *     name="PASSWORD_HASH",
     *     length=180
     * )
     */
    protected $password;

    /**
     * @var int
     * 
     * @ORM\Column(
     *     type="smallint",
     *     name="ACTIVE",
     *     options={"default":1}
     * )
     */
    protected $active = 1;

    /**
     * @var null|PersistentCollection<Post>
     * 
     * @ORM\OneToMany(
     *     targetEntity="\Partitura\Entity\Post",
     *     mappedBy="author"
     * )
     */
    protected $createdPosts;

    /**
     * @var null|PersistentCollection<Post>
     * 
     * @ORM\OneToMany(
     *     targetEntity="\Partitura\Entity\Post",
     *     mappedBy="lastEditor"
     * )
     */
    protected $lastEditedPosts;

    /**
     * @var null|PersistentCollection<ArchivedPost>
     * 
     * @ORM\OneToMany(
     *     targetEntity="\Partitura\Entity\ArchivedPost",
     *     mappedBy="author"
     * )
     */
    protected $archivedPosts;

    /**
     * @var null|PersistentCollection<PostView>
     * 
     * @ORM\OneToMany(
     *     targetEntity="\Partitura\Entity\PostView",
     *     mappedBy="user"
     * )
     */
    protected $postsViews;

    public function __construct()
    {
        $this->datetimeCreated = new DateTime();
    }

    /**
     * @return string
     */
    public function getUsername() : string
    {
        return (string)$this->username;
    }

    /**
     * @param string $username
     *
     * @return $this
     */
    public function setUsername(string $username) : static
    {
        $this->username = $username;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     * {@inheritDoc}
     * @see UserInterface
     */
    public function getUserIdentifier() : string
    {
        return $this->getUsername();
    }

    /**
     * {@inheritDoc}
     * @see UserInterface
     */
    public function getRoles() : array
    {
        if ($this->role !== null) {
            return [$this->role->getCode()];
        }

        return ["ROLE_USER"];
    }

    /**
     * @return Role
     */
    public function getRole() : Role
    {
        return $this->role;
    }

    /**
     * @param Role $role
     *
     * @return $this
     */
    public function setRole(Role $role) : static
    {
        $this->role = $role;

        return $this;
    }

    /**
     * {@inheritDoc}
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword() : string
    {
        return $this->password;
    }

    /**
     * {@inheritDoc}
     *
     * @return $this
     */
    public function setPassword(string $password) : static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return bool
     */
    public function isActive() : bool
    {
        return $this->active === 1;
    }

    /**
     * @param bool $active
     *
     * @return $this
     */
    public function setActive(bool $active) : static
    {
        $this->active = $active ? 1 : 0;

        return $this;
    }

    /**
     * @return null|PersistentCollection<Post>
     */
    public function getCreatedPosts() : ?PersistentCollection
    {
        return $this->createdPosts;
    }

    /**
     * @param Post $post
     *
     * @return $this
     */
    public function addCreatedPost(Post $post) : static
    {
        if (!$this->createdPosts->contains($post)) {
            $this->createdPosts->add($post);
        }

        return $this;
    }

    /**
     * @return null|PersistentCollection<Post>
     */
    public function getLastEditedPosts() : ?PersistentCollection
    {
        return $this->lastEditedPosts;
    }

    /**
     * @param Post $post
     *
     * @return $this
     */
    public function addLastEditedPost(Post $post) : static
    {
        if (!$this->lastEditedPosts->contains($post)) {
            $this->lastEditedPosts->add($post);
        }

        return $this;
    }

    /**
     * @return null|PersistentCollection<ArchivedPost>
     */
    public function getArchivedPosts() : ?PersistentCollection
    {
        return $this->archivedPosts;
    }

    /**
     * @return null|PersistentCollection<PostView>
     */
    public function getPostsViews() : ?PersistentCollection
    {
        return $this->postsViews;
    }

    /**
     * {@inheritDoc}
     * 
     * @throws NotImplementedException
     */
    public function eraseCredentials() : void
    {
        throw new NotImplementedException("Nothing to erase.");
    }
}
