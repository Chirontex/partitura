<?php
declare(strict_types=1);

namespace Partitura\EventSubscriber\Profile\MainInfo;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\ArrayTransformerInterface;
use Partitura\Dto\Form\AbstractFormRequestDto;
use Partitura\Event\Form\Profile\MainInfoHandlingProcessEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class CreateResponseParameters
 * @package Partitura\EventSubscriber\Profile\MainInfo
 */
class CreateResponseParameters implements EventSubscriberInterface
{
    /** @var ArrayTransformerInterface */
    protected $arrayTransformer;

    public function __construct(ArrayTransformerInterface $arrayTransformer)
    {
        $this->arrayTransformer = $arrayTransformer;
    }

    /** {@inheritDoc} */
    public static function getSubscribedEvents() : array
    {
        return [MainInfoHandlingProcessEvent::class => "handleEvent"];
    }

    /**
     * @param MainInfoHandlingProcessEvent $event
     */
    public function handleEvent(MainInfoHandlingProcessEvent $event) : void
    {
        $requestDto = $event->getRequestDto();

        if (
            $requestDto === null
            || !$event->getResponseParameters()->isEmpty()
        ) {
            return;
        }

        $event->setResponseParameters($this->createParametersCollection($requestDto));
    }

    /**
     * @param AbstractFormRequestDto $requestDto
     *
     * @return ArrayCollection<string, mixed>
     */
    protected function createParametersCollection(AbstractFormRequestDto $requestDto) : ArrayCollection
    {
        $parametersCollection = new ArrayCollection($this->arrayTransformer->toArray($requestDto));

        if ($parametersCollection->containsKey(AbstractFormRequestDto::CSRF_TOKEN_KEY)) {
            $parametersCollection->remove(AbstractFormRequestDto::CSRF_TOKEN_KEY);
        }

        return $parametersCollection;
    }
}
