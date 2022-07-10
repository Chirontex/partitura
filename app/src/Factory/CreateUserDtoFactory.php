<?php
declare(strict_types=1);

namespace Partitura\Factory;

use JMS\Serializer\ArrayTransformerInterface;
use JMS\Serializer\SerializationContext;
use Partitura\Dto\CreateUserDto;
use Partitura\Exception\ArgumentException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class CreateUserDtoFactory
 * @package Partitura\Factory
 */
class CreateUserDtoFactory
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
     * @return CreateUserDto
     */
    public function createByConsoleInput(InputInterface $input) : CreateUserDto
    {
        $dtoArr = [];

        foreach ($this->getKeys() as $key) {
            $value = $input->getArgument($key);

            if ($key === CreateUserDto::ROLE && empty($value)) {
                continue;
            }

            $dtoArr[$key] = $value;
        }

        /** @var CreateUserDto */
        $dto = $this->arrayTransformer->fromArray($dtoArr, CreateUserDto::class);

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
            new CreateUserDto(),
            (new SerializationContext())->setSerializeNull(true)
        ));
    }
}
