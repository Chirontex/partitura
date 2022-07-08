<?php
declare(strict_types=1);

namespace Partitura\Entity;

use Doctrine\ORM\Mapping as ORM;
use Partitura\Entity\Trait\HasDatetimeCreatedTrait;
use Partitura\Entity\Trait\HasIdTrait;
use Partitura\Repository\PostViewRepository;

/**
 * Post's view statistics entity.
 * @package Partitura\Entity
 * 
 * @ORM\Entity(repositoryClass=PostViewRepository::class)
 * @ORM\Table(name=PostView::TABLE_NAME)
 */
class PostView
{
    use HasIdTrait,
        HasDatetimeCreatedTrait;

    public const TABLE_NAME = "pt_posts_views";

    /**
     * @var Post
     * 
     * @ORM\JoinColumn(
     *     name="POST_ID",
     *     referencedColumnName="ID",
     *     nullable=false
     * )
     * @ORM\ManyToOne(
     *     targetEntity="\Partitura\Entity\Post",
     *     fetch="EAGER",
     *     inversedBy="views"
     * )
     */
    protected $post;

    /**
     * @var User
     * 
     * @ORM\JoinColumn(
     *     name="USER_ID",
     *     referencedColumnName="ID"
     * )
     * @ORM\ManyToOne(
     *     targetEntity="\Partitura\Entity\User",
     *     fetch="EAGER",
     *     inversedBy="postsViews"
     * )
     */
    protected $user;

    /**
     * @var string
     * 
     * @ORM\Column(
     *     type="text",
     *     name="IP_ADDRESS"
     * )
     */
    protected $ipAddress;

    /**
     * @return null|Post
     */
    public function getPost() : ?Post
    {
        return $this->post;
    }

    /**
     * @param Post $post
     *
     * @return $this
     */
    public function setPost(Post $post) : static
    {
        $this->post = $post;

        return $this;
    }

    /**
     * @return null|User
     */
    public function getUser() : ?User
    {
        return $this->user;
    }

    /**
     * @param User $user
     *
     * @return $this
     */
    public function setUser(User $user) : static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return string
     */
    public function getIpAddress() : string
    {
        return (string)$this->ipAddress;
    }

    /**
     * @param string $ipAddress
     *
     * @return $this
     */
    public function setIpAddress(string $ipAddress) : static
    {
        $this->ipAddress = $ipAddress;

        return $this;
    }
}
