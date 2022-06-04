<?php
declare(strict_types=1);

namespace Partitura\Controller\Api;

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

    /**
     * @return JsonResponse
     * 
     * @Route("/", name=BlogController::ROUTE_API_BLOG, methods={"GET"})
     */
    public function blog() : JsonResponse
    {
        return $this->json(["data" => []]);
    }
}
