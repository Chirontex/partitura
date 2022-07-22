<?php
declare(strict_types=1);

namespace Partitura\Controller;

use Partitura\Exception\EntityNotFoundException;
use Partitura\Manager\PostManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class PostController
 * @package Partitura\Controller
 */
class PostController extends AbstractController
{
    /** @var PostManager */
    protected $postManager;

    public function __construct(PostManager $postManager)
    {
        $this->postManager = $postManager;
    }

    /**
     * @param Request $request
     * 
     * @throws NotFoundHttpException
     *
     * @return Response
     */
    public function showPost(Request $request) : Response
    {
        try {
            // TODO: Убрать это в фабрику DTO после добавления шаблона для постов.
            $post = $this->postManager->getPostByUri($request->getPathInfo());

            return new Response($post->getContent());
        } catch (EntityNotFoundException $e) {
            throw $this->createNotFoundException($e->getMessage());
        }
    }
}
