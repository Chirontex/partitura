<?php
declare(strict_types=1);

namespace Partitura\Controller;

use Partitura\Exception\EntityNotFoundException;
use Partitura\Manager\PostManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
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
     * @throws MethodNotAllowedHttpException
     * @throws NotFoundHttpException
     *
     * @return Response
     */
    public function showPost(Request $request) : Response
    {
        if ($request->getMethod() !== Request::METHOD_GET) {
            throw new MethodNotAllowedHttpException(
                [Request::METHOD_GET],
                sprintf("Posts are available only with %s method.", Request::METHOD_GET)
            );
        }

        try {
            // TODO: Убрать это в фабрику DTO после добавления шаблона для постов.
            $post = $this->postManager->getPostByUri($request->getPathInfo());

            return new Response($post->getContent());
        } catch (EntityNotFoundException $e) {
            throw $this->createNotFoundException($e->getMessage());
        }
    }
}
