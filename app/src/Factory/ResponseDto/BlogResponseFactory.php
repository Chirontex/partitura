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
        
        if ($requestDto->getLimit() > 0) {
            $fullPages = (int)($postsCount / $requestDto->getLimit());
            $pages = $postsCount % $requestDto->getLimit() > 0 ? $fullPages + 1 : $fullPages;
        } else {
            $pages = 1;
        }

        $responseDto = (new BlogResponseDto())
            ->setPages($pages)
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
            $preview = $post->getPreview();

            $result->add(
                (new BlogPostDto())
                    ->setTitle($post->getTitle())
                    ->setPreview(empty($preview) ? $post->getContent() : $preview)
                    ->setAuthor((string)$post->getAuthor()?->getUsername())
                    ->setUri($post->getUri())
                    ->setDateCreated($post->getDatetimeCreated())
            );
        }

        return $result;
    }
}
