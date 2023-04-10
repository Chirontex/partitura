<?php

declare(strict_types=1);

namespace Partitura\EventSubscriber\Profile\MainInfo;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\ArrayTransformerInterface;
use Partitura\Dto\Form\AbstractFormRequestDto;
use Partitura\Enum\CsrfTokenValidationResultEnum;
use Partitura\Event\Form\Profile\MainInfoHandlingProcessEvent;
use Partitura\Exception\EntityNotFoundException;
use Partitura\Exception\ForbiddenAccessException;
use Partitura\Service\User\CurrentUserService;
use Partitura\Service\User\UserFieldValuesGettingService;
use Partitura\Service\User\UserFieldValuesSavingService;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class HandleForm
 */
class HandleForm implements EventSubscriberInterface
{
    public function __construct(
        protected ArrayTransformerInterface $arrayTransformer,
        protected UserFieldValuesSavingService $userFieldValuesSavingService,
        protected CurrentUserService $currentUserService,
        protected UserFieldValuesGettingService $userFieldValuesGettingService
    ) {
    }

    /** {@inheritDoc} */
    public static function getSubscribedEvents(): array
    {
        return [MainInfoHandlingProcessEvent::class => "handleEvent"];
    }

    /**
     *
     * @throws EntityNotFoundException
     * @throws ForbiddenAccessException
     */
    public function handleEvent(MainInfoHandlingProcessEvent $event): void
    {
        $requestDto = $event->getRequestDto();

        if (
            $requestDto === null
            || !$event->getResponseParameters()->isEmpty()
        ) {
            return;
        }

        $currentUser = $this->currentUserService->getCurrentUser();

        if ($currentUser === null) {
            throw new ForbiddenAccessException("Unauthorized access is forbidden for this form.");
        }

        $userFieldValues = $this->userFieldValuesGettingService->getValuesWithEmpty($currentUser);
        $csrfTokenValidationResult = $event->getCsrfTokenValidationResult();

        if (
            $csrfTokenValidationResult === null
            || (
                $csrfTokenValidationResult !== null
                && $csrfTokenValidationResult === CsrfTokenValidationResultEnum::INVALID
            )
        ) {
            throw new ForbiddenAccessException("CSRF token isn't valid.");
        }

        if ($csrfTokenValidationResult === CsrfTokenValidationResultEnum::EMPTY) {
            // Form not need to be processed.
            $event->setFieldsToResponseParameters($userFieldValues->toArray());

            return;
        }

        $formFieldsCollection = $this->createFormFieldsCollection($requestDto);

        $this->userFieldValuesSavingService->saveFromCollection($currentUser, $formFieldsCollection);

        // @var string $userFieldCode
        foreach (array_diff(
            $userFieldValues->getKeys(),
            $formFieldsCollection->getKeys()
        ) as $code) {
            $formFieldsCollection->set($code, $userFieldValues->get($code));
        }

        $event
            ->setFieldsToResponseParameters($formFieldsCollection->toArray())
            ->setResponseParameter("message", "Данные успешно сохранены!");
    }

    /**
     *
     * @return ArrayCollection<string, mixed>
     */
    protected function createFormFieldsCollection(AbstractFormRequestDto $requestDto): ArrayCollection
    {
        $formFieldsCollection = new ArrayCollection($this->arrayTransformer->toArray($requestDto));

        if ($formFieldsCollection->containsKey(AbstractFormRequestDto::CSRF_TOKEN_KEY)) {
            $formFieldsCollection->remove(AbstractFormRequestDto::CSRF_TOKEN_KEY);
        }

        return $formFieldsCollection;
    }
}
