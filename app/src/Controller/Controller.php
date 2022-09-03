<?php
declare(strict_types=1);

namespace Partitura\Controller;

use JMS\Serializer\Serializer;
use Partitura\Factory\SettingsDtoFactory;
use Partitura\Kernel;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

/**
 * Abstract Partitura Controller.
 * @package Partitura\Controller
 */
abstract class Controller extends AbstractController
{
    /** {@inheritDoc} */
    protected function render(
        string $view,
        array $parameters = [],
        ?Response $response = null
    ) : Response {
        return parent::render($view, $this->prepareParameters($parameters), $response);
    }

    /**
     * @param array<string, mixed> $parameters
     *
     * @return array<string, mixed>
     */
    protected function prepareParameters(array $parameters = []) : array
    {
        return array_merge($parameters, $this->getSettings());
    }

    /**
     * @return Serializer
     */
    protected function getSerializer() : Serializer
    {
        return Kernel::getInstance()->getService("jms_serializer");
    }

    /**
     * @return array<string, mixed>
     */
    protected function getSettings() : array
    {
        /** @var SettingsDtoFactory */
        $settingsDtoFactory = Kernel::getInstance()->getService(SettingsDtoFactory::class);

        return $this->getSerializer()->toArray($settingsDtoFactory->createDto());
    }
}
