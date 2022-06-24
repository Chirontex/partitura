<?php
declare(strict_types=1);

namespace Partitura\Factory\ResponseDto;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;
use Partitura\Dto\Api\BlogPostDto;
use Partitura\Dto\Api\BlogRequestDto;
use Partitura\Dto\Api\BlogResponseDto;
use Partitura\Entity\Post;
use Partitura\Enum\PostTypeEnum;
use Partitura\Event\BlogViewEvent;
use Partitura\Repository\PostRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

/**
 * Class BlogResponseFactory
 * @package Partitura\Factory\ResponseDto
 */
class BlogResponseFactory
{
    /** @var PostRepository */
    protected $postRepository;

    /** @var EventDispatcherInterface */
    protected $eventDispatcher;

    public function __construct(
        ManagerRegistry $registry,
        EventDispatcherInterface $eventDispatcher
    ) {
        $this->postRepository = $registry->getRepository(Post::class);
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param BlogRequestDto $requestDto
     *
     * @return BlogResponseDto
     */
    public function createBlogResponseDto(BlogRequestDto $requestDto) : BlogResponseDto
    {
        $postsCount = $this->postRepository->count(["inBlog" => 1]);
        $fullPages = $postsCount/$requestDto->getLimit();

        $responseDto = (new BlogResponseDto())
            ->setPages(
                $postsCount % $requestDto->getLimit() === 0 ? $fullPages : $fullPages + 1
            )
            ->setPosts($this->createBlogPostCollection($requestDto));

        $this->eventDispatcher->dispatch(new BlogViewEvent($responseDto));

        return $responseDto;
    }

    /**
     * @param BlogRequestDto $requestDto
     *
     * @return ArrayCollection<BlogPostDto>
     */
    protected function createBlogPostCollection(BlogRequestDto $requestDto) : ArrayCollection
    {
        $result = new ArrayCollection();
        $limit = $requestDto->getLimit();
        $offset = $limit * ($requestDto->getPage() - 1);

        $posts = $this->postRepository->findBy(
            [
                "type" => PostTypeEnum::PUBLISHED->value,
                "inBlog" => 1,
            ],
            ["datetimeCreated" => "DESC"],
            $limit > 0 ? $limit : null,
            $offset > 0 ? $offset : null
        );

        foreach ($posts as $post) {
            $result->add(
                (new BlogPostDto())
                    ->setTitle($post->getTitle())
                    ->setPreview($post->getPreview())
                    ->setAuthor((string)$post->getAuthor()?->getUsername())
                    ->setUri($post->getUri())
                    ->setDateCreated($post->getDatetimeCreated())
            );
        }

        return $result;
    }
}
