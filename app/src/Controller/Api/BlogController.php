<?php

declare(strict_types=1);

namespace Partitura\Controller\Api;

use JMS\Serializer\ArrayTransformerInterface;
use Partitura\Dto\Api\BlogRequestDto;
use Partitura\Factory\ResponseDto\BlogResponseFactory;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BlogController.
 *
 * @Route("/api/blog")
 */
class BlogController extends AbstractController
{
    public const ROUTE_API_BLOG = "partitura_api_blog";

    public function __construct(
        protected BlogResponseFactory $blogResponseFactory,
        protected ArrayTransformerInterface $arrayTransformer
    ) {
    }

    /**
     *
     *
     * @Route("/", name=BlogController::ROUTE_API_BLOG, methods={"GET"})
     */
    public function blog(BlogRequestDto $request): JsonResponse
    {
        return $this->json($this->arrayTransformer->toArray(
            $this->blogResponseFactory->createBlogResponseDto($request)
        ));
    }
}
