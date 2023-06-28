<?php

declare(strict_types=1);

namespace Partitura\Tests\Unit\Factory;

use Partitura\Entity\Post;
use Partitura\Exception\PostViewException;
use Partitura\Factory\PostViewFactory;
use Partitura\Tests\Unit\Mock\CurrentUserService;
use Partitura\Tests\Unit\SymfonyUnitTemplate;
use Symfony\Component\HttpFoundation\Request;

/**
 * @internal
 *
 * @covers \Partitura\Factory\PostViewFactory
 */
final class PostViewFactoryTest extends SymfonyUnitTemplate
{
    protected CurrentUserService $currentUserService;

    protected PostViewFactory $postViewFactory;

    protected function _before(): void
    {
        parent::_before();

        $this->currentUserService = new CurrentUserService();
        $this->postViewFactory = new PostViewFactory($this->currentUserService);
    }

    public function testCreateByPostRequestWithoutIpAndUser(): void
    {
        $this->expectException(PostViewException::class);

        $this->postViewFactory->createByPostRequest(new Post(), new Request());
    }
}
