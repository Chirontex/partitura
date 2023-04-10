<?php

declare(strict_types=1);

namespace Partitura\Entity;

use Doctrine\ORM\Mapping as ORM;
use Partitura\Entity\Trait\HasContentTrait;
use Partitura\Entity\Trait\HasDatetimeCreatedTrait;
use Partitura\Entity\Trait\HasIdTrait;
use Partitura\Entity\Trait\HasTitleTrait;
use Partitura\Repository\ArchivedPostRepository;

/**
 * Posts archive copy entity.
 */
#[ORM\Entity(repositoryClass: ArchivedPostRepository::class)]
#[ORM\Table(name: ArchivedPost::TABLE_NAME)]
class ArchivedPost
{
    use HasIdTrait;
    use HasTitleTrait;
    use HasContentTrait;
    use HasDatetimeCreatedTrait;

    public const TABLE_NAME = "pt_posts_archive";

    #[ORM\JoinColumn(
        name: 'POST_ID',
        referencedColumnName: 'ID',
        nullable: false
    )]
    #[ORM\ManyToOne(
        targetEntity: '\Partitura\Entity\Post',
        fetch: 'EAGER',
        inversedBy: 'archive'
    )]
    protected ?Post $post = null;

    #[ORM\JoinColumn(
        name: 'AUTHOR_ID',
        referencedColumnName: 'ID',
        nullable: false
    )]
    #[ORM\ManyToOne(
        targetEntity: '\Partitura\Entity\User',
        fetch: 'EAGER',
        inversedBy: 'archivedPosts'
    )]
    protected ?User $author = null;

    public function getPost(): ?Post
    {
        return $this->post;
    }

    /**
     *
     * @return $this
     */
    public function setPost(Post $post): static
    {
        $this->post = $post;

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
}
