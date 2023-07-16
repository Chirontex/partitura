<?php

declare(strict_types=1);

namespace Partitura\Tests\Unit\Builder\Factory\ResponseDto;

use Codeception\Test\Unit;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\AbstractManagerRegistry;
use Partitura\Dto\Api\BlogPostDto;
use Partitura\Dto\Api\BlogRequestDto;
use Partitura\Entity\Post;
use Partitura\Entity\User;
use Partitura\Enum\PostTypeEnum;
use Partitura\Factory\ResponseDto\BlogResponseFactory;
use Partitura\Repository\PostRepository;
use Partitura\Tests\Unit\Builder\Registry\MockManagerRegistryBuilder;
use PHPUnit\Framework\MockObject\MockObject;
use ReflectionProperty;
use Symfony\Component\HttpKernel\Debug\TraceableEventDispatcher;

/**
 * @internal
 *
 * @covers \Partitura\Factory\ResponseDto\BlogResponseFactory
 */
final class BlogResponseFactoryTest extends Unit
{
    private const MAX_PAGES = 10;

    /** @var ?Post[] */
    private array $posts = [];

    public function testCreateBlogResponseDtoByEmptyPostCollection(): void
    {
        $blogResponseDto = $this->createBlogResponseFactory()
            ->createBlogResponseDto(new BlogRequestDto())
        ;

        $this->assertCount(0, $blogResponseDto->getPosts());
        $this->assertEquals(0, $blogResponseDto->getPages());
    }

    public function testCreateBlogResponseDtoByTypeIrrelevantPostCollection(): void
    {
        $this->posts[1] = (new Post())
            ->setId(1)
            ->setType(PostTypeEnum::DRAFT)
            ->setInBlog(true)
        ;

        $blogResponseDto = $this->createBlogResponseFactory()
            ->createBlogResponseDto((new BlogRequestDto())
                ->setPage(1)
                ->setLimit(20))
        ;

        $this->assertCount(0, $blogResponseDto->getPosts());
        $this->assertEquals(0, $blogResponseDto->getPages());
    }

    public function testCreateBlogResponseDtoByInBlogIrrelevantPostCollection(): void
    {
        $this->posts[1] = (new Post())
            ->setId(1)
            ->setType(PostTypeEnum::PUBLISHED)
            ->setInBlog(false)
        ;

        $blogResponseDto = $this->createBlogResponseFactory()
            ->createBlogResponseDto((new BlogRequestDto())
                ->setPage(1)
                ->setLimit(20))
        ;

        $this->assertCount(0, $blogResponseDto->getPosts());
        $this->assertEquals(0, $blogResponseDto->getPages());
    }

    public function testCreateBlogResponseDtoWithOnePost(): void
    {
        $author = (new User())->setUsername('Author');

        $this->posts[1] = (new Post())
            ->setId(1)
            ->setType(PostTypeEnum::PUBLISHED)
            ->setInBlog(true)
            ->setDateTimeCreated((new DateTime())->setTimestamp(1))
            ->setTitle('Post 1')
            ->setPreview('Post 1 preview')
            ->setName('post_1')
            ->setAuthor($author)
        ;

        $blogResponseDto = $this->createBlogResponseFactory()
            ->createBlogResponseDto((new BlogRequestDto())
                ->setPage(1)
                ->setLimit(1))
        ;

        $this->assertCount(1, $blogResponseDto->getPosts());
        $this->assertBlogPostDtoEqualsPost(
            $this->posts[1],
            $blogResponseDto->getPosts()->first()
        );
        $this->assertEquals(1, $blogResponseDto->getPages());
    }

    /**
     * @dataProvider getManyPostsArgs
     */
    public function testCreateBlogResponseDtoWithPostsCorrelatingWithLimit(
        int $pages,
        int $page
    ): void {
        $limit = 3;
        $author = (new User())->setUsername('Author');

        for ($i = 1; $i <= $limit * $pages; ++$i) {
            $this->posts[$i] = (new Post())
                ->setId($i)
                ->setType(PostTypeEnum::PUBLISHED)
                ->setInBlog(true)
                ->setDateTimeCreated((new DateTime())->setTimestamp(1 + $i))
                ->setTitle(sprintf('Post %u', $i))
                ->setPreview(sprintf('Post %u preview', $i))
                ->setName(sprintf('post_%u', $i))
                ->setAuthor($author)
            ;
        }

        $blogResponseDto = $this->createBlogResponseFactory()
            ->createBlogResponseDto((new BlogRequestDto())
                ->setPage($page)
                ->setLimit($limit))
        ;

        $this->assertCount($limit, $blogResponseDto->getPosts());

        $offset = 0;

        /** @var BlogPostDto $blogPostDto */
        foreach ($blogResponseDto->getPosts() as $blogPostDto) {
            $postId = $this->calculatePostIdForBlogPostDto(
                $limit,
                $offset,
                $page
            );
            $post = $this->posts[$postId];

            $this->assertBlogPostDtoEqualsPost($post, $blogPostDto);

            ++$offset;
        }

        $this->assertEquals($pages, $blogResponseDto->getPages());
    }

    /**
     * @dataProvider getManyPostsArgs
     */
    public function testCreateBlogResponseDtoWithPostsNotCorrelatingWithLimit(
        int $pages,
        int $page
    ): void {
        $limit = 3;
        $author = (new User())->setUsername('Author');

        for ($i = 1; $i <= $limit * ($pages - 1) + 1; ++$i) {
            $this->posts[$i] = (new Post())
                ->setId($i)
                ->setType(PostTypeEnum::PUBLISHED)
                ->setInBlog(true)
                ->setDateTimeCreated((new DateTime())->setTimestamp(1 + $i))
                ->setTitle(sprintf('Post %u', $i))
                ->setPreview(sprintf('Post %u preview', $i))
                ->setName(sprintf('post_%u', $i))
                ->setAuthor($author)
            ;
        }

        $blogResponseDto = $this->createBlogResponseFactory()
            ->createBlogResponseDto((new BlogRequestDto())
                ->setPage($page)
                ->setLimit($limit))
        ;

        $this->assertCount(
            $pages === $page ? 1 : $limit,
            $blogResponseDto->getPosts()
        );

        $offset = 0;

        /** @var BlogPostDto $blogPostDto */
        foreach ($blogResponseDto->getPosts() as $blogPostDto) {
            $postId = $this->calculatePostIdForBlogPostDto(
                $limit,
                $offset,
                $page
            );
            $post = $this->posts[$postId];

            $this->assertBlogPostDtoEqualsPost($post, $blogPostDto);

            ++$offset;
        }

        $this->assertEquals($pages, $blogResponseDto->getPages());
    }

    public function getManyPostsArgs(): array
    {
        $data = [];

        for ($pages = 1; $pages <= self::MAX_PAGES; ++$pages) {
            for ($page = 1; $page <= $pages; ++$page) {
                $data[] = [$pages, $page];
            }
        }

        return $data;
    }

    private function assertBlogPostDtoEqualsPost(
        Post $post,
        BlogPostDto $blogPostDto
    ): void {
        $this->assertEquals($post->getTitle(), $blogPostDto->getTitle());
        $this->assertEquals(
            $post->getPreview(),
            $blogPostDto->getPreview()
        );
        $this->assertEquals(
            $post->getAuthor()->getUsername(),
            $blogPostDto->getAuthor()
        );
        $this->assertEquals($post->getUri(), $blogPostDto->getUri());
        $this->assertEquals(
            $post
                ->getDatetimeCreated()
                ->format(BlogPostDto::DATE_CREATED_FORMAT),
            $blogPostDto->getDateCreated()
        );
    }

    private function createBlogResponseFactory(): BlogResponseFactory
    {
        /** @var MockObject|TraceableEventDispatcher $eventDispatcher */
        $eventDispatcher = $this->makeEmpty(TraceableEventDispatcher::class);

        return new BlogResponseFactory(
            $this->createMockManagerRegistry(),
            $eventDispatcher
        );
    }

    private function createMockManagerRegistry(): AbstractManagerRegistry
    {
        return (new MockManagerRegistryBuilder($this))
            ->createMockManagerRegistry(function (): PostRepository {
                /** @var MockObject|PostRepository $postRepository */
                $postRepository = $this->make(PostRepository::class, [
                    'count' => function (array $criteria): int {
                        return array_reduce(
                            $this->posts,
                            function (int $count, Post $post) use ($criteria): int {
                                return $count + (int)$this->isEntityMeetsCriteria($post, $criteria);
                            },
                            0
                        );
                    },
                    'findBy' => function (
                        array $criteria,
                        array $orderBy,
                        ?int $limit = null,
                        ?int $offset = null
                    ): ArrayCollection {
                        if (!empty($criteria)) {
                            $posts = array_filter(
                                $this->posts,
                                function (Post $post) use ($criteria): bool {
                                    return $this->isEntityMeetsCriteria($post, $criteria);
                                }
                            );
                        } else {
                            $posts = $this->posts;
                        }

                        if (!empty($orderBy)) {
                            uasort(
                                $posts,
                                static function (Post $a, Post $b) use ($orderBy): int {
                                    $orderByKeys = array_keys($orderBy);
                                    $propertyName = reset($orderByKeys);
                                    $method = $orderBy[$propertyName];

                                    $aValue = (new ReflectionProperty($a, $propertyName))->getValue($a);
                                    $bValue = (new ReflectionProperty($b, $propertyName))->getValue($b);

                                    if ($aValue === $bValue) {
                                        $result = 0;
                                    } elseif ($aValue > $bValue) {
                                        $result = 1;
                                    } else {
                                        $result = -1;
                                    }

                                    if (strtoupper($method) === 'DESC') {
                                        $result = $result * -1;
                                    }

                                    return $result;
                                }
                            );

                            $posts = new ArrayCollection(array_slice(
                                $posts,
                                (int)$offset,
                                (int)$limit,
                                true
                            ));
                        }

                        return $posts;
                    },
                ]);

                return $postRepository;
            })
        ;
    }

    /**
     * @param array<string, mixed> $criteria
     */
    private function isEntityMeetsCriteria(object $entity, array $criteria): bool
    {
        foreach ($criteria as $propertyName => $neededValue) {
            $reflectionProperty = new ReflectionProperty($entity, $propertyName);

            if ($reflectionProperty->getValue($entity) !== $neededValue) {
                return false;
            }
        }

        return true;
    }

    private function calculatePostIdForBlogPostDto(
        int $limit,
        int $offset,
        int $page
    ): int {
        return count($this->posts) - $offset - (
            $page > 0 ? ($page - 1) * $limit : 0
        );
    }
}
