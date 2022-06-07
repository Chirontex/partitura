<?php
declare(strict_types=1);

namespace Partitura\Factory\RequestDto;

use Doctrine\Common\Collections\ArrayCollection;
use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\SerializationContext;
use Partitura\Exception\ArgumentException;
use Partitura\Interfaces\RequestDtoFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AbstractRequestDtoFactory
 * @package Partitura\Factory\RequestDto
 */
abstract class AbstractRequestDtoFactory implements RequestDtoFactoryInterface
{
    /** @var ValidatorInterface */
    protected $validator;

    /** @var ArrayTransformerInterface */
    protected $arrayTransformer;

    public function __construct(
        ValidatorInterface $validator,
        ArrayTransformerInterface $arrayTransformer
    ) {
        $this->validator = $validator;
        $this->arrayTransformer = $arrayTransformer;
    }

    /** {@inheritDoc} */
    public function createFromRequest(Request $request) : object
    {
        $dto = $this->createDto($this->prepareDataFromRequest($request));
        $errors = $this->validator->validate($dto);

        if (count($errors) > 0) {
            throw new ArgumentException((string)$errors);
        }

        return $dto;
    }

    /**
     * @param ArrayCollection<string, mixed> $data
     *
     * @return object
     */
    protected function createDto(ArrayCollection $data) : object
    {
        return $this->arrayTransformer->fromArray($data->toArray(), static::getDtoClass());
    }

    /**
     * @return string[]
     */
    protected function getFieldNames() : array
    {
        $dto = $this->arrayTransformer->toArray(
            new (static::getDtoClass()),
            (new SerializationContext())->setSerializeNull(true)
        );

        return array_keys($dto);
    }

    /**
     * @param Request $request
     *
     * @return ArrayCollection<string, mixed>
     */
    protected function prepareDataFromRequest(Request $request) : ArrayCollection
    {
        $result = new ArrayCollection();

        foreach ($this->getFieldNames() as $fieldName) {
            $result->set($fieldName, $request->get($fieldName));
        }

        return $result;
    }
}
