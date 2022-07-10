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
 * @package Partitura\Factory\ConsoleInputDto
 */
abstract class AbstractConsoleInputDtoFactory
{
    /** @var ArrayTransformerInterface */
    protected $arrayTransformer;

    /** @var ValidatorInterface */
    protected $validator;

    public function __construct(
        ArrayTransformerInterface $arrayTransformer,
        ValidatorInterface $validator
    ) {
        $this->arrayTransformer = $arrayTransformer;
        $this->validator = $validator;
    }

    /**
     * @param InputInterface $input
     * 
     * @throws ArgumentException
     *
     * @return object
     */
    public function createByConsoleInput(InputInterface $input) : object
    {
        $dtoArr = [];

        foreach ($this->getKeys() as $key) {
            $dtoArr[$key] = $input->getArgument($key);
        }

        $dto = $this->arrayTransformer->fromArray($dtoArr, $this->getDtoClass());
        $validationErrors = $this->validator->validate($dto);

        if (count($validationErrors) <= 0 ) {
            return $dto;
        }

        throw new ArgumentException((string)$validationErrors);
    }

    /**
     * @return string[]
     */
    protected function getKeys() : array
    {
        return array_keys($this->arrayTransformer->toArray(
            new ($this->getDtoClass()),
            (new SerializationContext())->setSerializeNull(true)
        ));
    }

    /**
     * @return string
     */
    abstract protected function getDtoClass() : string;
}
