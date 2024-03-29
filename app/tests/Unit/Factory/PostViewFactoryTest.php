<?php

declare(strict_types=1);

namespace Partitura\Tests\Unit\Factory;

use Codeception\Test\Unit;
use Partitura\Entity\Post;
use Partitura\Entity\User;
use Partitura\Exception\PostViewException;
use Partitura\Factory\PostViewFactory;
use Partitura\Tests\Unit\Mock\CurrentUserService;
use Symfony\Component\HttpFoundation\Request;

/**
 * @internal
 *
 * @covers \Partitura\Factory\PostViewFactory
 */
final class PostViewFactoryTest extends Unit
{
    protected CurrentUserService $currentUserService;

    protected PostViewFactory $postViewFactory;

    protected function _before(): void
    {
        $this->currentUserService = new CurrentUserService();
        $this->postViewFactory = new PostViewFactory($this->currentUserService);
    }

    public function testCreateByPostRequestWithoutIpAndUser(): void
    {
        $this->expectException(PostViewException::class);

        $this->postViewFactory->createByPostRequest(new Post(), new Request());
    }

    public function testCreateByPostRequestWithUser(): void
    {
        $user = new User();

        $this->currentUserService->setCurrentUser($user);

        $post = new Post();
        $postView = $this->postViewFactory->createByPostRequest(
            $post,
            new Request()
        );

        $this->assertEquals($post, $postView->getPost());
        $this->assertEquals($user, $postView->getUser());
        $this->assertEmpty($postView->getIpAddress());
    }

    public function testCreateByPostRequestWithIpAddress(): void
    {
        $ip = '127.0.0.1';
        $request = new Request(server: ['REMOTE_ADDR' => $ip]);
        $post = new Post();
        $postView = $this->postViewFactory->createByPostRequest(
            $post,
            $request
        );

        $this->assertEquals($post, $postView->getPost());
        $this->assertEquals($ip, $postView->getIpAddress());
        $this->assertNull($postView->getUser());
    }

    public function testCreateByPostRequestWithIpAndUser(): void
    {
        $ip = '127.0.0.1';
        $request = new Request(server: ['REMOTE_ADDR' => $ip]);
        $post = new Post();
        $user = new User();

        $this->currentUserService->setCurrentUser($user);

        $postView = $this->postViewFactory->createByPostRequest(
            $post,
            $request
        );

        $this->assertEquals($post, $postView->getPost());
        $this->assertEquals($user, $postView->getUser());
        $this->assertEquals($ip, $postView->getIpAddress());
    }
}
