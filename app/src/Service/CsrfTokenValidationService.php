<?php
declare(strict_types=1);

namespace Partitura\Service;

use Partitura\Dto\Form\AbstractFormRequestDto;
use Partitura\Exception\LogicException;
use Partitura\Interfaces\CsrfTokenIdResolverInterface;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

/**
 * Class CsrfTokenValidationService
 * @package Partitura\Service
 */
class CsrfTokenValidationService
{
    public function __construct(
        protected CsrfTokenManagerInterface $csrfTokenManager,
        protected CsrfTokenIdResolverInterface $csrfTokenIdResolver
    ) {
    }

    /**
     * @param AbstractFormRequestDto $requestDto
     *
     * @throws LogicException Throws if token is empty.
     * @return bool
     */
    public function isFormRequestDtoTokenValid(AbstractFormRequestDto $requestDto) : bool
    {
        return $this->isTokenValid(
            $this->csrfTokenIdResolver->resolveCsrfTokenIdByRouteName($requestDto->getRouteName()),
            $requestDto->getCsrfToken()
        );
    }

    /**
     * @param string $id
     * @param string $token
     *
     * @throws LogicException Throws if token is empty.
     * @return bool
     */
    public function isTokenValid(string $id, string $token) : bool
    {
        if (empty($token)) {
            throw new LogicException("CSRF token is empty.");
        }

        return $this->csrfTokenManager->isTokenValid(new CsrfToken($id, $token));
    }
}
