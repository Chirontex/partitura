<?php

declare(strict_types=1);

namespace Partitura\EventSubscriber\ExceptionResponse;

use Partitura\Exception\ArgumentException;
use Partitura\Exception\CaseNotFoundException;
use Partitura\Interfaces\ViewResolverInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Twig\Environment;

/**
 * Class HandleArgumentExceptionResponse
 * @package Partitura\EventSubscriber\ExceptionResponse
 */
class HandleArgumentExceptionResponse extends AbstractHandleExceptionResponse
{
    protected ViewResolverInterface $viewResolver;

    protected Environment $twig;

    public function __construct(
        ViewResolverInterface $viewResolver,
        Environment $twig
    ) {
        $this->viewResolver = $viewResolver;
        $this->twig = $twig;
    }

    /** {@inheritDoc} */
    public static function getSubscribedEvents() : array
    {
        return ["kernel.exception" => ["handleExceptionResponse", -2]];
    }

    /** {@inheritDoc} */
    public function handleExceptionResponse(ExceptionEvent $event) : void
    {
        if (!$this->isSubscriberRelevant($event)) {
            return;
        }

        $view = $this->getView($event->getRequest()->attributes->get("_route"));

        if (empty($view)) {
            return;
        }

        // TODO: добавить получение параметров из контроллеров для проброса в рендер
        $event->setResponse(new Response($this->twig->render($view, [])));
    }

    /** {@inheritDoc} */
    protected function isSubscriberRelevant(ExceptionEvent $event) : bool
    {
        return $event->getResponse() === null
            && $event->getThrowable() instanceof ArgumentException;
    }

    /**
     * @param string $route
     *
     * @return null|string
     */
    protected function getView(string $route) : ?string
    {
        try {
            return $this->viewResolver->resolveViewByRoute($route);
        } catch (CaseNotFoundException) {
            return null;
        }
    }
}
