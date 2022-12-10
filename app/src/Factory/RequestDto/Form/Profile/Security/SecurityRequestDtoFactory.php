<?php

declare(strict_types=1);

namespace Partitura\Factory\RequestDto\Form\Profile\Security;

use JMS\Serializer\ArrayTransformerInterface;
use Partitura\Dto\Form\Profile\Security\EmptyRequestDto;
use Partitura\Dto\Form\Profile\Security\SecurityRequestDto;
use Partitura\Exception\ArgumentException;
use Partitura\Factory\RequestDto\AbstractRequestDtoFactory;
use Partitura\Factory\RequestDto\Form\Profile\Security\ChangePasswordRequestDtoFactory;
use Partitura\Factory\RequestDto\Form\Profile\Security\DropRememberMeTokensRequestDtoFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class SecurityRequestDtoFactory
 * @package Partitura\Factory\RequestDto\Form\Profile\Security
 */
class SecurityRequestDtoFactory extends AbstractRequestDtoFactory
{
    /** @var AbstractRequestDtoFactory[] */
    protected $requestDtoFactories = [];

    public function __construct(
        ValidatorInterface $validator,
        ArrayTransformerInterface $arrayTransformer,
        ChangePasswordRequestDtoFactory $changePasswordRequestDtoFactory,
        DropRememberMeTokensRequestDtoFactory $dropRememberMeTokensRequestDtoFactory
    ) {
        parent::__construct($validator, $arrayTransformer);

        $this->requestDtoFactories = [
            $changePasswordRequestDtoFactory,
            $dropRememberMeTokensRequestDtoFactory,
        ];
    }

    /** {@inheritDoc} */
    public function createFromRequest(Request $request) : object
    {
        foreach ($this->requestDtoFactories as $requestDtoFactory) {
            try {
                return $requestDtoFactory->createFromRequest($request);
            } catch (ArgumentException) {
                // nothing to do here
            }
        }

        return new EmptyRequestDto();
    }

    /** {@inheritDoc} */
    public static function getDtoClass() : string
    {
        return SecurityRequestDto::class;
    }
}
