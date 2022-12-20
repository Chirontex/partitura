<?php
declare(strict_types=1);

namespace Partitura\EventSubscriber;

use InvalidArgumentException;
use Partitura\EventSubscriber\Trait\RequestEventSubscriberTrait;
use Partitura\Exception\ArgumentException;
use Partitura\Interfaces\ViewResolverInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Throwable;
use Twig\Environment;

/**
 * Class ExceptionResponse
 * @package Partitura\EventSubscriber
 */
class ExceptionResponse implements EventSubscriberInterface
{
    use RequestEventSubscriberTrait;

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
        return ["kernel.exception" => ["handleException", -1]];
    }

    /**
     * @param ExceptionEvent $event
     */
    public function handleException(ExceptionEvent $event) : void
    {
        $e = $event->getThrowable();
        $request = $event->getRequest();
        $isNeedJsonResponse = $this->isNeedJsonResponse($request);
        $responseCode = $this->getResponseCode($e, $isNeedJsonResponse);

        if ($isNeedJsonResponse) {
            $event->setResponse(new JsonResponse(
                ["message" => $e->getMessage()],
                $responseCode
            ));
        } elseif ($e instanceof ArgumentException) {
            // TODO: добавить получение параметров из контроллеров для проброса в рендер
            $event->setResponse(new Response($this->twig->render(
                $this->viewResolver->resolveViewByRoute(
                    $request->attributes->get("_route")
                ),
                []
            )));
        }
    }

    /**
     * @param Throwable $e
     * @param bool isJsonResponse
     *
     * @return int
     */
    protected function getResponseCode(Throwable $e, bool $isJsonResponse = false) : int
    {
        if ($e->getCode() > 399) {
            return $e->getCode();
        }

        return match (get_class($e)) {
            default => Response::HTTP_INTERNAL_SERVER_ERROR,
            ArgumentException::class => $isJsonResponse
                ? Response::HTTP_BAD_REQUEST
                : Response::HTTP_OK,
            InvalidArgumentException::class => Response::HTTP_BAD_REQUEST,
        };
    }
}
