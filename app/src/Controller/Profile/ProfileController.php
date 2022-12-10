<?php
declare(strict_types=1);

namespace Partitura\Controller\Profile;

use Partitura\Controller\AbstractFormController;
use Partitura\Dto\Form\Profile\MainInfoRequestDto;
use Partitura\Dto\Form\Profile\Security\SecurityRequestDto;
use Partitura\Dto\SettingsDto;
use Partitura\Event\Form\Profile\MainInfoHandlingProcessEvent;
use Partitura\Event\Form\Profile\SecurityHandlingProcessEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProfileController
 * @package Partitura\Controller\Profile
 * 
 * @Route("/profile")
 */
class ProfileController extends AbstractFormController
{
    public const ROUTE_MAIN_INFO = "partitura_profile_main_info";
    public const ROUTE_SECURITY = "partitura_profile_security";

    public const MAIN_INFO_CSRF_TOKEN_ID = "profile_main_info_csrf_token";
    public const SECURITY_CSRF_TOKEN_ID = "profile_security_csrf_token";

    /**
     * @param MainInfoRequestDto $requestDto 
     *
     * @return Response
     * 
     * @Route("/", name=ProfileController::ROUTE_MAIN_INFO, methods={"GET", "POST"})
     */
    public function mainInfo(MainInfoRequestDto $requestDto) : Response
    {
        $parameters = array_merge(
            $this->processForm(new MainInfoHandlingProcessEvent($requestDto)),
            ["csrf_token_id" => static::MAIN_INFO_CSRF_TOKEN_ID]
        );

        return $this->render("genesis/profile/main_info.html.twig", $parameters);
    }

    /**
     * @param SecurityRequestDto $requestDto
     *
     * @return Response
     * 
     * @Route("/security", name=ProfileController::ROUTE_SECURITY, methods={"GET", "POST"})
     */
    public function security(SecurityRequestDto $requestDto) : Response
    {
        $parameters = array_merge(
            $this->processForm(new SecurityHandlingProcessEvent($requestDto)),
            ["csrf_token_id" => static::SECURITY_CSRF_TOKEN_ID]
        );

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
