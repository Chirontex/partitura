<?php

declare(strict_types=1);

namespace Partitura\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\PersistentCollection;
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
 */
#[ORM\Entity(repositoryClass: PostRepository::class)]
#[ORM\Table(name: Post::TABLE_NAME)]
class Post
{
    use HasIdTrait;
    use HasNameTrait;
    use HasTitleTrait;
    use HasContentTrait;
    use HasDatetimeCreatedTrait;
    use HasDatetimeUpdatedTrait;

    public const TABLE_NAME = "pt_posts";

    #[ORM\JoinColumn(
        name: 'PARENT_ID',
        referencedColumnName: 'ID'
    )]
    #[ORM\OneToOne(
        targetEntity: '\Partitura\Entity\Post',
        fetch: 'EAGER',
        inversedBy: 'child'
    )]
    protected ?Post $parent = null;

    #[ORM\OneToOne(
        targetEntity: '\Partitura\Entity\Post',
        fetch: 'EAGER',
        mappedBy: 'parent'
    )]
    protected ?Post $child = null;

    #[ORM\JoinColumn(
        name: 'AUTHOR_ID',
        referencedColumnName: 'ID',
        nullable: false
    )]
    #[ORM\ManyToOne(
        targetEntity: '\Partitura\Entity\User',
        fetch: 'EAGER',
        inversedBy: 'createdPosts'
    )]
    protected ?User $author = null;

    #[ORM\JoinColumn(
        name: 'LAST_EDITOR_ID',
        referencedColumnName: 'ID',
        nullable: false
    )]
    #[ORM\ManyToOne(
        targetEntity: '\Partitura\Entity\User',
        fetch: 'EAGER',
        inversedBy: 'lastEditedPosts'
    )]
    protected ?User $lastEditor = null;

    #[ORM\Column(
        type: 'string',
        name: 'TYPE',
        length: 180
    )]
    protected ?string $type = null;

    #[ORM\Column(
        type: 'smallint',
        name: 'IN_BLOG',
        options: ["default" => 1]
    )]
    protected int $inBlog = 1;

    #[ORM\Column(type: 'text', name: 'PREVIEW')]
    protected ?string $preview = null;

    /**
     * @var null|PersistentCollection<ArchivedPost>
     */
    #[ORM\OneToMany(
        targetEntity: '\Partitura\Entity\ArchivedPost',
        mappedBy: 'post'
    )]
    protected ?PersistentCollection $archive;

    /**
     * @var null|PersistentCollection<PostView>
     */
    #[ORM\OneToMany(
        targetEntity: '\Partitura\Entity\PostView',
        mappedBy: 'post'
    )]
    protected ?PersistentCollection $views;

    public function __construct()
    {
        $this->type = PostTypeEnum::DRAFT->value;
    }

    public function getParent(): ?static
    {
        return $this->parent;
    }

    /**
     *
     * @return $this
     */
    public function setParent(?Post $parent): static
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

    public function getChild(): ?static
    {
        return $this->child;
    }

    /**
     * This method did not update relation. Use setParent() of the child post to do it.
     *
     * @return $this
     */
    public function setChild(?Post $child): static
    {
        $this->child = $child;

        return $this;
    }

    public function getAuthor(): ?User
    {
        return $this->author;
    }

    /**
     *
     * @return $this
     */
    public function setAuthor(User $author): static
    {
        $this->author = $author;

        return $this;
    }

    public function getLastEditor(): ?User
    {
        return $this->lastEditor;
    }

    /**
     *
     * @return $this
     */
    public function setLastEditor(User $lastEditor): static
    {
        $this->lastEditor = $lastEditor;

        return $this;
    }

    /**
     * @throws CaseNotFoundException
     */
    public function getType(): PostTypeEnum
    {
        return PostTypeEnum::getInstanceByValue($this->type);
    }

    /**
     *
     * @return $this
     */
    public function setType(PostTypeEnum $type): static
    {
        $this->type = $type->value;

        return $this;
    }

    public function isInBlog(): bool
    {
        return $this->inBlog === 1;
    }

    /**
     *
     * @return $this
     */
    public function setInBlog(bool $isInBlog): static
    {
        $this->inBlog = $isInBlog ? 1 : 0;

        return $this;
    }

    public function getPreview(): string
    {
        return (string)$this->preview;
    }

    /**
     *
     * @return $this
     */
    public function setPreview(string $preview): static
    {
        $this->preview = $preview;

        return $this;
    }

    /**
     * @return null|PersistentCollection<ArchivedPost>
     */
    public function getArchive(): ?PersistentCollection
    {
        return $this->archive;
    }

    /**
     * @return null|PersistentCollection<PostView>
     */
    public function getViews(): ?PersistentCollection
    {
        return $this->views;
    }

    public function getUri(): string
    {
        $names = [];
        $post = $this;

        while ($post !== null) {
            array_unshift($names, $post->getName());

            $post = $post->getParent();
        }

        return sprintf("/%s", implode("/", $names));
    }
}
