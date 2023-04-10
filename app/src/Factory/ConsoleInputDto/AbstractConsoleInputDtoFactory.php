<?php

declare(strict_types=1);

namespace Partitura\Factory\ConsoleInputDto;

use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\SerializationContext;
use Partitura\Exception\ArgumentException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class AbstractConsoleInputDtoFactory
 */
abstract class AbstractConsoleInputDtoFactory
{
    public function __construct(
        protected ArrayTransformerInterface $arrayTransformer,
        protected ValidatorInterface $validator
    ) {
    }

    /**
     *
     * @throws ArgumentException
     *
     */
    public function createByConsoleInput(InputInterface $input): object
    {
        $dtoArr = [];

        foreach ($this->getKeys() as $key) {
            $dtoArr[$key] = $input->getArgument($key);
        }

        $dto = $this->arrayTransformer->fromArray($dtoArr, $this->getDtoClass());
        $validationErrors = $this->validator->validate($dto);

        if (count($validationErrors) <= 0) {
            return $dto;
        }

        throw new ArgumentException([$validationErrors]);
    }

    /**
     * @return string[]
     */
    protected function getKeys(): array
    {
        return array_keys($this->arrayTransformer->toArray(
            new ($this->getDtoClass()),
            (new SerializationContext())->setSerializeNull(true)
        ));
    }

    abstract protected function getDtoClass(): string;
}
