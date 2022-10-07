<?php
declare(strict_types=1);

namespace Partitura\Controller\Profile;

use Partitura\Controller\Controller;
use Partitura\Event\Form\Profile\MainInfoHandlingProcessEvent;
use Partitura\Event\Form\Profile\MainInfoHandlingStartEvent;
use Partitura\Exception\ForbiddenAccessException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class MainInfoController
 * @package Partitura\Controller\Profile
 * 
 * @Route("/profile")
 */
class MainInfoController extends Controller
{
    public const ROUTE_MAIN_INFO = "partitura_main_info";
    public const CSRF_TOKEN = "main_info_csrf_token";

    /** @var EventDispatcherInterface */
    protected $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param Request $request 
     *
     * @return Response
     * 
     * @Route("/", name=MainInfoController::ROUTE_MAIN_INFO, methods={"GET"})
     */
    public function profile(Request $request) : Response
    {
        $startEvent = new MainInfoHandlingStartEvent($request);

        $this->eventDispatcher->dispatch($startEvent);

        $requestDto = $startEvent->getRequestDto();

        if ($requestDto !== null) {
            $processEvent = new MainInfoHandlingProcessEvent($requestDto);

            try {
                $this->eventDispatcher->dispatch($processEvent);
            } catch (ForbiddenAccessException $e) {
                throw $this->createAccessDeniedException($e->getMessage());
            }

            $parameters = $processEvent->getResponseParameters()->toArray();
        } else {
            $parameters = [];
        }

        return $this->render("genesis/profile/main_info.html.twig", $parameters);
    }
}
