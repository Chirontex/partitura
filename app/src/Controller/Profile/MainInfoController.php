<?php
declare(strict_types=1);

namespace Partitura\Controller\Profile;

use Partitura\Controller\Controller;
use Partitura\Dto\Form\Profile\MainInfoRequestDto;
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

    /**
     * @param MainInfoRequestDto $requestDto 
     *
     * @return Response
     * 
     * @Route("/", name=MainInfoController::ROUTE_MAIN_INFO, methods={"GET"})
     */
    public function profile(MainInfoRequestDto $requestDto) : Response
    {
        $csrfToken = $requestDto->getCsrfToken();
        $parameters = [];

        if (!empty($csrfToken)) {
            // TODO: логика обработки формы
        }

        return $this->render("genesis/profile/main_info.html.twig", $parameters);
    }
}
