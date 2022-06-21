<?php
declare(strict_types=1);

namespace Partitura\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MainController
 * @package Partitura\Controller
 * 
 * @Route("/")
 */
class MainController extends AbstractController
{
    public const ROUTE_INDEX = "partitura_main_index";

    /**
     * @return Response
     * 
     * @Route("/", name=MainController::ROUTE_INDEX, methods={"GET"})
     */
    public function index() : Response
    {
        return $this->render("genesis/main/blog.html.twig");
    }
}
