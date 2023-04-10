<?php

declare(strict_types=1);

namespace Partitura\Factory\RequestDto\Form\Profile\Security;

use JMS\Serializer\ArrayTransformerInterface;
use Partitura\Dto\Form\AbstractFormRequestDto;
use Partitura\Dto\Form\Profile\Security\DropRememberMeTokensRequestDto;
use Partitura\Dto\Form\Profile\Security\EmptyRequestDto;
use Partitura\Dto\Form\Profile\Security\SecurityRequestDto;
use Partitura\Factory\RequestDto\AbstractRequestDtoFactory;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Class SecurityRequestDtoFactory
 */
class SecurityRequestDtoFactory extends AbstractRequestDtoFactory
{
    public function __construct(
        ValidatorInterface $validator,
        ArrayTransformerInterface $arrayTransformer,
        protected ChangePasswordRequestDtoFactory $changePasswordRequestDtoFactory,
        protected DropRememberMeTokensRequestDtoFactory $dropRememberMeTokensRequestDtoFactory
    ) {
        parent::__construct($validator, $arrayTransformer);
    }

    /** {@inheritDoc} */
    public function createFromRequest(Request $request): object
    {
        if ($this->isDropRememberMeTokensRequest($request)) {
            return $this->dropRememberMeTokensRequestDtoFactory->createFromRequest($request);
        } elseif ($request->get(AbstractFormRequestDto::CSRF_TOKEN_KEY) !== null) {
            return $this->changePasswordRequestDtoFactory->createFromRequest($request);
        }

        return new EmptyRequestDto();
    }

    /** {@inheritDoc} */
    public static function getDtoClass(): string
    {
        return SecurityRequestDto::class;
    }

    protected function isDropRememberMeTokensRequest(Request $request): bool
    {
        return $request->get(DropRememberMeTokensRequestDto::DROP_REMEMBERME_TOKENS_KEY) !== null
            && $request->get(DropRememberMeTokensRequestDto::CSRF_TOKEN_KEY) !== null;
    }
}
