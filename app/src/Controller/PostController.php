<?php
declare(strict_types=1);

namespace Partitura\Controller;

use Partitura\Exception\EntityNotFoundException;
use Partitura\Factory\ResponseDto\PostResponseFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class PostController
 * @package Partitura\Controller
 */
class PostController extends Controller
{
    public function __construct(protected PostResponseFactory $postResponseFactory)
    {
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
            return $this->render(
                "genesis/main/post.html.twig",
                $this->getSerializer()->toArray(
                    $this->postResponseFactory->createResponseByUri($request->getPathInfo())
                )
            );
        } catch (EntityNotFoundException $e) {
            throw $this->createNotFoundException($e->getMessage());
        }
    }
}
