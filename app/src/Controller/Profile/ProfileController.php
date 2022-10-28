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
 * Class ProfileController
 * @package Partitura\Controller\Profile
 * 
 * @Route("/profile")
 */
class ProfileController extends Controller
{
    public const ROUTE_MAIN_INFO = "partitura_profile_main_info";
    public const MAIN_INFO_CSRF_TOKEN_ID = "profile_main_info_csrf_token";

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
     * @Route("/", name=ProfileController::ROUTE_MAIN_INFO, methods={"GET", "POST"})
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
                throw $this->createAccessDeniedException($e->getMessage(), $e);
            }

            $parameters = $processEvent->getResponseParameters()->toArray();
        } else {
            $parameters = [];
        }

        return $this->render("genesis/profile/main_info.html.twig", $parameters);
    }

    /** {@inheritDoc} */
    protected function prepareParameters(array $parameters = []) : array
    {
        return array_merge(
            parent::prepareParameters($parameters),
            ["csrf_token_id" => static::MAIN_INFO_CSRF_TOKEN_ID]
        );
    }
}
