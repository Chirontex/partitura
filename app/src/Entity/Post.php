<?php
declare(strict_types=1);

namespace Partitura\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Partitura\Entity\Trait\HasContentTrait;
use Partitura\Entity\Trait\HasDatetimeCreatedTrait;
use Partitura\Entity\Trait\HasDatetimeUpdatedTrait;
use Partitura\Entity\Trait\HasIdTrait;
use Partitura\Entity\Trait\HasNameTrait;
use Partitura\Entity\Trait\HasTitleTrait;
use Partitura\Enum\PostTypeEnum;
use Partitura\Exception\CaseNotFoundException;
use Partitura\Repository\PostRepository;

/**
 * Post main entity.
 * @package Partitura\Entity
 * 
 * @ORM\Entity(repositoryClass=PostRepository::class)
 * @ORM\Table(name=Post::TABLE_NAME)
 */
class Post
{
    use HasIdTrait,
        HasNameTrait,
        HasTitleTrait,
        HasContentTrait,
        HasDatetimeCreatedTrait,
        HasDatetimeUpdatedTrait;

    public const TABLE_NAME = "pt_posts";

    /**
     * @var null|static
     * 
     * @ORM\JoinColumn(
     *     name="PARENT_ID",
     *     referencedColumnName="ID"
     * )
     * @ORM\OneToOne(
     *     targetEntity="\Partitura\Entity\Post",
     *     fetch="EAGER",
     *     inversedBy="child"
     * )
     */
    protected $parent;

    /**
     * @var null|static
     * 
     * @ORM\OneToOne(
     *     targetEntity="\Partitura\Entity\Post",
     *     fetch="EAGER",
     *     inversedBy="parent"
     * )
     */
    protected $child;

    /**
     * @var User
     * 
     * @ORM\JoinColumn(
     *     name="AUTHOR_ID",
     *     referencedColumnName="ID",
     *     nullable=false
     * )
     * @ORM\ManyToOne(
     *     targetEntity="\Partitura\Entity\User",
     *     fetch="EAGER",
     *     inversedBy="createdPosts"
     * )
     */
    protected $author;

    /**
     * @var User
     * 
     * @ORM\JoinColumn(
     *     name="LAST_EDITOR_ID",
     *     referencedColumnName="ID",
     *     nullable=false
     * )
     * @ORM\ManyToOne(
     *     targetEntity="\Partitura\Entity\User",
     *     fetch="EAGER",
     *     inversedBy="lastEditedPosts"
     * )
     */
    protected $lastEditor;

    /**
     * @var string
     * 
     * @ORM\Column(
     *     type="string",
     *     name="TYPE",
     *     length=180
     * )
     */
    protected $type;

    /**
     * @var ArrayCollection<ArchivedPost>
     * 
     * @OneToMany(
     *     targetEntity="\Partitura\Entity\ArchivedPost",
     *     mappedBy="post"
     * )
     */
    protected $archive;

    public function __construct()
    {
        $this->type = PostTypeEnum::DRAFT->value;
        $this->archive = new ArrayCollection();
    }

    /**
     * @return null|static
     */
    public function getParent() : ?static
    {
        return $this->parent;
    }

    /**
     * @param null|Post $parent
     *
     * @return $this
     */
    public function setParent(?Post $parent) : static
    {
        if ($this->parent !== null) {
            $this->parent->setChild(null);
        }

        if ($parent !== null) {
            $parent->setChild($this);
        }

        $this->parent = $parent;

        return $this;
    }

    /**
     * @return null|static
     */
    public function getChild() : ?static
    {
        return $this->child;
    }

    /**
     * This method did not update relation. Use setParent() of the child post to do it.
     * 
     * @param null|Post $child
     *
     * @return $this
     */
    public function setChild(?Post $child) : static
    {
        $this->child = $child;

        return $this;
    }

    /**
     * @return null|User
     */
    public function getAuthor() : ?User
    {
        return $this->author;
    }

    /**
     * @param User $author
     *
     * @return $this
     */
    public function setAuthor(User $author) : static
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return null|User
     */
    public function getLastEditor() : ?User
    {
        return $this->lastEditor;
    }

    /**
     * @param User $lastEditor
     *
     * @return $this
     */
    public function setLastEditor(User $lastEditor) : static
    {
        $this->lastEditor = $lastEditor;

        return $this;
    }

    /**
     * @throws CaseNotFoundException
     * @return PostTypeEnum
     */
    public function getType() : PostTypeEnum
    {
        return PostTypeEnum::getInstanceByValue($this->type);
    }

    /**
     * @param PostTypeEnum $type
     *
     * @return $this
     */
    public function setType(PostTypeEnum $type) : static
    {
        $this->type = $type->value;

        return $this;
    }

    /**
     * @return ArrayCollection<ArchivedPost>
     */
    public function getArchive() : ArrayCollection
    {
        return $this->archive;
    }
}
