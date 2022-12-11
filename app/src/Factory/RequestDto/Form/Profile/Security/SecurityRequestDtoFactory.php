<?php

declare(strict_types=1);

namespace Partitura\Factory\RequestDto\Form\Profile\Security;

use JMS\Serializer\ArrayTransformerInterface;
use Partitura\Dto\Form\AbstractFormRequestDto;
use Partitura\Dto\Form\Profile\Security\DropRememberMeTokensRequestDto;
use Partitura\Dto\Form\Profile\Security\EmptyRequestDto;
use Partitura\Dto\Form\Profile\Security\SecurityRequestDto;
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
    protected ChangePasswordRequestDtoFactory $changePasswordRequestDtoFactory;

    protected DropRememberMeTokensRequestDtoFactory $dropRememberMeTokensRequestDtoFactory;

    public function __construct(
        ValidatorInterface $validator,
        ArrayTransformerInterface $arrayTransformer,
        ChangePasswordRequestDtoFactory $changePasswordRequestDtoFactory,
        DropRememberMeTokensRequestDtoFactory $dropRememberMeTokensRequestDtoFactory
    ) {
        parent::__construct($validator, $arrayTransformer);

        $this->changePasswordRequestDtoFactory = $changePasswordRequestDtoFactory;
        $this->dropRememberMeTokensRequestDtoFactory = $dropRememberMeTokensRequestDtoFactory;
    }

    /** {@inheritDoc} */
    public function createFromRequest(Request $request) : object
    {
        if ($this->isDropRememberMeTokensRequest($request)) {
            return $this->dropRememberMeTokensRequestDtoFactory->createFromRequest($request);
        } elseif ($request->get(AbstractFormRequestDto::CSRF_TOKEN_KEY) !== null) {
            return $this->changePasswordRequestDtoFactory->createFromRequest($request);
        }

        return new EmptyRequestDto();
    }

    /** {@inheritDoc} */
    public static function getDtoClass() : string
    {
        return SecurityRequestDto::class;
    }

    /**
     * @param Request $request
     *
     * @return bool
     */
    protected function isDropRememberMeTokensRequest(Request $request) : bool
    {
        return $request->get(DropRememberMeTokensRequestDto::DROP_REMEMBERME_TOKENS_KEY) !== null
            && $request->get(DropRememberMeTokensRequestDto::CSRF_TOKEN_KEY) !== null;
    }
}
