<?php
declare(strict_types=1);

namespace Partitura\Controller;

use Partitura\Event\Form\RequestDtoCreateEvent;
use Partitura\Event\Form\RequestDtoHandleEvent;
use Partitura\Exception\ForbiddenAccessException;
use Partitura\Exception\InvalidArgumentException;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Class AbstractFormController
 * @package Partitura\Controller
 */
abstract class AbstractFormController extends Controller
{
    /** @var EventDispatcherInterface */
    protected $eventDispatcher;

    public function __construct(EventDispatcherInterface $eventDispatcher)
    {
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * @param string $requestDtoCreateEventClass
     * @param string $requestDtoHandleEventClass
     * @param Request $request
     *
     * @throws AccessDeniedException
     * @throws InvalidArgumentException
     * @return array<string, mixed>
     */
    protected function processForm(
        string $requestDtoCreateEventClass,
        string $requestDtoHandleEventClass,
        Request $request
    ) : array {
        foreach ([
            $requestDtoCreateEventClass => RequestDtoCreateEvent::class,
            $requestDtoHandleEventClass => RequestDtoHandleEvent::class,
        ] as $givenEventClass => $requiredEventClass) {
            $this->checkEventClass($givenEventClass, $requiredEventClass);
        }

        /** @var RequestDtoCreateEvent */
        $createEvent = new $requestDtoCreateEventClass($request);

        $this->eventDispatcher->dispatch($createEvent);

        $requestDto = $createEvent->getRequestDto();
        
        if ($requestDto !== null) {
            /** @var RequestDtoHandleEvent */
            $processEvent = new $requestDtoHandleEventClass($requestDto);

            try {
                $this->eventDispatcher->dispatch($processEvent);
            } catch (ForbiddenAccessException $e) {
                throw $this->createAccessDeniedException($e->getMessage(), $e);
            }

            return $processEvent->getResponseParameters()->toArray();
        }

        return [];
    }

    /**
     * @param string $givenEventClass
     * @param string $requiredEventClass
     * 
     * @throws InvalidArgumentException
     */
    private function checkEventClass(
        string $givenEventClass,
        string $requiredEventClass
    ) : void {
        if (!is_a($givenEventClass, $requiredEventClass, true)) {
            throw new InvalidArgumentException(sprintf(
                "\"%s\" class must extend \"%s\".",
                $givenEventClass,
                $requiredEventClass
            ));
        }
    }
}
