<?php
declare(strict_types=1);

namespace Partitura\EventSubscriber\Profile\MainInfo;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\ArrayTransformerInterface;
use Partitura\Dto\Form\AbstractFormRequestDto;
use Partitura\Event\Form\Profile\MainInfoHandlingProcessEvent;
use Partitura\Exception\EntityNotFoundException;
use Partitura\Exception\ForbiddenAccessException;
use Partitura\Exception\LogicException;
use Partitura\Service\CsrfTokenValidationService;
use Partitura\Service\User\CurrentUserService;
use Partitura\Service\User\UserFieldValuesSavingService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class HandleForm
 * @package Partitura\EventSubscriber\Profile\MainInfo
 */
class HandleForm implements EventSubscriberInterface
{
    /** @var ArrayTransformerInterface */
    protected $arrayTransformer;

    /** @var UserFieldValuesSavingService */
    protected $userFieldValuesSavingService;

    /** @var CurrentUserService */
    protected $currentUserService;

    /** @var CsrfTokenValidationService */
    protected $csrfTokenValidationService;

    public function __construct(
        ArrayTransformerInterface $arrayTransformer,
        UserFieldValuesSavingService $userFieldValuesSavingService,
        CurrentUserService $currentUserService,
        CsrfTokenValidationService $csrfTokenValidationService
    ) {
        $this->arrayTransformer = $arrayTransformer;
        $this->userFieldValuesSavingService = $userFieldValuesSavingService;
        $this->currentUserService = $currentUserService;
        $this->csrfTokenValidationService = $csrfTokenValidationService;
    }

    /** {@inheritDoc} */
    public static function getSubscribedEvents() : array
    {
        return [MainInfoHandlingProcessEvent::class => "handleEvent"];
    }

    /**
     * @param MainInfoHandlingProcessEvent $event
     * 
     * @throws EntityNotFoundException
     * @throws ForbiddenAccessException
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

        try {
            if (!$this->csrfTokenValidationService->isFormRequestDtoTokenValid($requestDto)) {
                throw new ForbiddenAccessException("CSRF token isn't valid.");
            }
        } catch (LogicException) {
            // Catch if CSRF token is empty. Form not need to be processed.
            return;
        }

        $currentUser = $this->currentUserService->getCurrentUser();

        if ($currentUser === null) {
            throw new ForbiddenAccessException("Unauthorized access is forbidden for this form.");
        }

        $formFieldsCollection = $this->createFormFieldsCollection($requestDto);

        $this->userFieldValuesSavingService->saveFromCollection($currentUser, $formFieldsCollection);

        $event->setResponseParameters($$formFieldsCollection);
    }

    /**
     * @param AbstractFormRequestDto $requestDto
     *
     * @return ArrayCollection<string, mixed>
     */
    protected function createFormFieldsCollection(AbstractFormRequestDto $requestDto) : ArrayCollection
    {
        $formFieldsCollection = new ArrayCollection($this->arrayTransformer->toArray($requestDto));

        if ($formFieldsCollection->containsKey(AbstractFormRequestDto::CSRF_TOKEN_KEY)) {
            $formFieldsCollection->remove(AbstractFormRequestDto::CSRF_TOKEN_KEY);
        }

        return $formFieldsCollection;
    }
}
