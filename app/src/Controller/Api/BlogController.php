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
 * Class BlogController
 * @package Partitura\Controller\Api
 * 
 * @Route("/api/blog")
 */
class BlogController extends AbstractController
{
    public const ROUTE_API_BLOG = "partitura_api_blog";

    /** @var BlogResponseFactory */
    protected $blogResponseFactory;

    /** @var ArrayTransformerInterface */
    protected $arrayTransformer;

    public function __construct(
        BlogResponseFactory $blogResponseFactory,
        ArrayTransformerInterface $arrayTransformer
    ) {
        $this->blogResponseFactory = $blogResponseFactory;
        $this->arrayTransformer = $arrayTransformer;
    }

    /**
     * @param BlogRequestDto $request
     * 
     * @return JsonResponse
     * 
     * @Route("/", name=BlogController::ROUTE_API_BLOG, methods={"GET"})
     */
    public function blog(BlogRequestDto $request) : JsonResponse
    {
        return $this->json(
            ["data" => $this->arrayTransformer->toArray(
                $this->blogResponseFactory->createBlogPostCollection($request)
            )]
        );
    }
}
