<?php
declare(strict_types=1);

namespace Partitura\Factory;

use Partitura\Entity\Post;
use Partitura\Entity\PostView;
use Partitura\Entity\User;
use Partitura\Exception\PostViewException;
use Partitura\Service\User\CurrentUserService;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class PostViewFactory
 * @package Partitura\Factory
 */
class PostViewFactory
{
    public function __construct(protected CurrentUserService $currentUserService)
    {
    }

    /**
     * @param Post $post
     * @param Request $request
     * 
     * @throws PostViewException
     *
     * @return PostView
     */
    public function createByPostRequest(Post $post, Request $request) : PostView
    {
        $clientIp = $request->getClientIp();
        $currentUser = $this->currentUserService->getCurrentUser();
        
        if (empty($clientIp) && !($currentUser instanceof User)) {
            throw new PostViewException("Requesting party cannot be identified by IP or user data.");
        }

        $postView = (new PostView())
            ->setPost($post)
            ->setIpAddress((string)$clientIp);

        if ($currentUser instanceof User) {
            $postView->setUser($currentUser);
        }

        return $postView;
    }
}
