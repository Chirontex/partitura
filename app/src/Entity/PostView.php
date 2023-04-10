<?php

declare(strict_types=1);

namespace Partitura\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Partitura\Entity\Trait\HasDatetimeCreatedTrait;
use Partitura\Entity\Trait\HasIdTrait;
use Partitura\Repository\PostViewRepository;

/**
 * Post's view statistics entity.
 */
#[ORM\Entity(repositoryClass: PostViewRepository::class)]
#[ORM\Table(name: PostView::TABLE_NAME)]
class PostView
{
    use HasIdTrait;
    use HasDatetimeCreatedTrait;

    public const TABLE_NAME = "pt_posts_views";

    #[ORM\JoinColumn(
        name: 'POST_ID',
        referencedColumnName: 'ID',
        nullable: false
    )]
    #[ORM\ManyToOne(
        targetEntity: '\Partitura\Entity\Post',
        fetch: 'EAGER',
        inversedBy: 'views'
    )]
    protected ?Post $post = null;

    #[ORM\JoinColumn(
        name: 'USER_ID',
        referencedColumnName: 'ID'
    )]
    #[ORM\ManyToOne(
        targetEntity: '\Partitura\Entity\User',
        fetch: 'EAGER',
        inversedBy: 'postsViews'
    )]
    protected ?User $user = null;

    #[ORM\Column(
        type: 'text',
        name: 'IP_ADDRESS'
    )]
    protected ?string $ipAddress = null;

    public function __construct()
    {
        $this->datetimeCreated = new DateTime();
    }

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

    public function getUser(): ?User
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

    public function getIpAddress(): string
    {
        return (string)$this->ipAddress;
    }

    /**
     *
     * @return $this
     */
    public function setIpAddress(string $ipAddress): static
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }
}
