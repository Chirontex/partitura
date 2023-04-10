<?php

declare(strict_types=1);

namespace Partitura\Factory\RequestDto;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\SerializationContext;
use Partitura\Exception\ArgumentException;
use Partitura\Interfaces\RequestDtoFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AbstractRequestDtoFactory.
 */
abstract class AbstractRequestDtoFactory implements RequestDtoFactoryInterface
{
    public function __construct(
        protected ValidatorInterface $validator,
        protected ArrayTransformerInterface $arrayTransformer
    ) {
    }

    /**
     * {@inheritDoc}
     *
     * @throws ArgumentException
     */
    public function createFromRequest(Request $request): object
    {
        $dto = $this->createDto($this->prepareDataFromRequest($request));

        $this->validate($dto);

        return $dto;
    }

    /**
     *
     * @throws ArgumentException
     */
    protected function validate(object $dto): void
    {
        $errors = $this->validator->validate($dto);

        if (count($errors) <= 0) {
            return;
        }

        $errorMessages = [];

        /** @var ConstraintViolationInterface $error */
        foreach ($errors as $error) {
            $errorMessages[] = $error->getMessage();
        }

        throw new ArgumentException($errorMessages);
    }

    /**
     * @param ArrayCollection<string, mixed> $data
     *
     */
    protected function createDto(ArrayCollection $data): object
    {
        return $this->arrayTransformer->fromArray($data->toArray(), static::getDtoClass());
    }

    /**
     * @return string[]
     */
    protected function getFieldNames(): array
    {
        $dto = $this->arrayTransformer->toArray(
            new (static::getDtoClass()),
            (new SerializationContext())->setSerializeNull(true)
        );

        return array_keys($dto);
    }

    /**
     *
     * @return ArrayCollection<string, mixed>
     */
    protected function prepareDataFromRequest(Request $request): ArrayCollection
    {
        $result = new ArrayCollection();

        foreach ($this->getFieldNames() as $fieldName) {
            $value = $request->get($fieldName);

            if ($value !== null) {
                $result->set($fieldName, $value);
            }
        }

        return $result;
    }
}
