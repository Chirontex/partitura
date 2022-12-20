<?php
declare(strict_types=1);

namespace Partitura\Controller;

use Partitura\Interfaces\ViewResolverInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MainController
 * @package Partitura\Controller
 * 
 * @Route("/")
 */
class MainController extends Controller
{
    public const ROUTE_INDEX = "partitura_main_index";

    protected ViewResolverInterface $viewResolver;

    public function __construct(ViewResolverInterface $viewResolver)
    {
        $this->viewResolver = $viewResolver;
    }

    /**
     * @return Response
     * 
     * @Route("/", name=MainController::ROUTE_INDEX, methods={"GET"})
     */
    public function index() : Response
    {
        // TODO: Добавить title для шаблона.
        return $this->render($this->viewResolver->resolveViewByRoute(static::ROUTE_INDEX));
    }
}
