<?php

declare(strict_types=1);

namespace Partitura\Tests\Unit\Builder\Factory\ResponseDto;

use Codeception\Test\Unit;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\AbstractManagerRegistry;
use Partitura\Dto\Api\BlogRequestDto;
use Partitura\Entity\Post;
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
 *
 * TODO реализовать другие кейсы
 */
final class BlogResponseFactoryTest extends Unit
{
    /** @var ?Post[] */
    private array $posts = [];

    public function testCreateBlogResponseDtoByEmptyPostCollection(): void
    {
        $blogResponseDto = $this->createBlogResponseFactory()
            ->createBlogResponseDto(new BlogRequestDto())
        ;

        $this->assertCount(0, $blogResponseDto->getPosts());
        $this->assertEquals(1, $blogResponseDto->getPages());
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
                        $posts = new ArrayCollection(array_slice(
                            $this->posts,
                            (int)$offset,
                            (int)$limit,
                            true
                        ));

                        if (!empty($criteria)) {
                            $posts = $posts->filter(function (Post $post) use ($criteria): bool {
                                return $this->isEntityMeetsCriteria($post, $criteria);
                            });
                        }

                        if (!empty($orderBy)) {
                            $posts = $posts->toArray();

                            uasort(
                                $posts,
                                static function (Post $a, Post $b) use ($orderBy): int {
                                    $propertyName = reset(array_keys($orderBy));
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

                            $posts = new ArrayCollection($posts);
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
}
