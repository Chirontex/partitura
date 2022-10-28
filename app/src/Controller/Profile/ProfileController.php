<?php
declare(strict_types=1);

namespace Partitura\Controller\Profile;

use Partitura\Controller\Controller;
use Partitura\Dto\SettingsDto;
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
    public const ROUTE_SECURITY = "partitura_profile_security";

    public const MAIN_INFO_CSRF_TOKEN_ID = "profile_main_info_csrf_token";
    public const SECURITY_CSRF_TOKEN_ID = "profile_security_csrf_token";

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
    public function mainInfo(Request $request) : Response
    {
        $startEvent = new MainInfoHandlingStartEvent($request);

        $this->eventDispatcher->dispatch($startEvent);

        $requestDto = $startEvent->getRequestDto();
        $parameters = [];

        if ($requestDto !== null) {
            $processEvent = new MainInfoHandlingProcessEvent($requestDto);

            try {
                $this->eventDispatcher->dispatch($processEvent);
            } catch (ForbiddenAccessException $e) {
                throw $this->createAccessDeniedException($e->getMessage(), $e);
            }

            $parameters = $processEvent->getResponseParameters()->toArray();
        }

        $parameters["csrf_token_id"] = static::MAIN_INFO_CSRF_TOKEN_ID;

        return $this->render("genesis/profile/main_info.html.twig", $parameters);
    }

    /**
     * @return Response
     * 
     * @Route("/security", name=ProfileController::ROUTE_SECURITY, methods={"GET", "POST"})
     */
    public function security() : Response
    {
        // TODO: реализовать обработку форм

        $parameters = ["csrf_token_id" => static::SECURITY_CSRF_TOKEN_ID];

        return $this->render("genesis/profile/security.html.twig", $parameters);
    }

    /** {@inheritDoc} */
    protected function createSettingsDto() : SettingsDto
    {
        $settingsDto = parent::createSettingsDto();
        $routes = $settingsDto->getRoutes();

        $routes->set("profile_security", static::ROUTE_SECURITY);

        return $settingsDto;
    }
}
