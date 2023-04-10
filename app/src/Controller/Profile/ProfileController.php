<?php

declare(strict_types=1);

namespace Partitura\Controller\Profile;

use Partitura\Controller\AbstractFormController;
use Partitura\Dto\Form\Profile\MainInfoRequestDto;
use Partitura\Dto\Form\Profile\Security\SecurityRequestDto;
use Partitura\Dto\SettingsDto;
use Partitura\Event\Form\Profile\MainInfoHandlingProcessEvent;
use Partitura\Event\Form\Profile\SecurityHandlingProcessEvent;
use Partitura\Interfaces\CsrfTokenIdResolverInterface;
use Partitura\Interfaces\ViewResolverInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProfileController
 *
 * @Route("/profile")
 */
class ProfileController extends AbstractFormController
{
    public const ROUTE_MAIN_INFO = "partitura_profile_main_info";

    public const ROUTE_SECURITY = "partitura_profile_security";

    public function __construct(
        EventDispatcherInterface $eventDispatcher,
        protected ViewResolverInterface $viewResolver,
        protected CsrfTokenIdResolverInterface $csrfTokenIdResolver
    ) {
        parent::__construct($eventDispatcher);
    }

    /**
     *
     *
     * @Route("/", name=ProfileController::ROUTE_MAIN_INFO, methods={"GET", "POST"})
     */
    public function mainInfo(MainInfoRequestDto $requestDto): Response
    {
        $parameters = array_merge(
            $this->processForm(new MainInfoHandlingProcessEvent($requestDto)),
            ["csrf_token_id" => $this->csrfTokenIdResolver->resolveCsrfTokenIdByRouteName(static::ROUTE_MAIN_INFO)]
        );

        return $this->render(
            $this->viewResolver->resolveViewByRoute(static::ROUTE_MAIN_INFO),
            $parameters
        );
    }

    /**
     *
     *
     * @Route("/security", name=ProfileController::ROUTE_SECURITY, methods={"GET", "POST"})
     */
    public function security(SecurityRequestDto $requestDto): Response
    {
        $parameters = array_merge(
            $this->processForm(new SecurityHandlingProcessEvent($requestDto)),
            ["csrf_token_id" => $this->csrfTokenIdResolver->resolveCsrfTokenIdByRouteName(static::ROUTE_SECURITY)]
        );

        return $this->render(
            $this->viewResolver->resolveViewByRoute(static::ROUTE_SECURITY),
            $parameters
        );
    }

    public static function completeSettingsDto(SettingsDto $settingsDto): void
    {
        $routes = $settingsDto->getRoutes();

        $routes->set("profile_security", static::ROUTE_SECURITY);
    }

    /** {@inheritDoc} */
    protected function createSettingsDto(): SettingsDto
    {
        $settingsDto = parent::createSettingsDto();

        static::completeSettingsDto($settingsDto);

        return $settingsDto;
    }
}
