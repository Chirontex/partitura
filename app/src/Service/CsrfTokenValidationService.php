<?php
declare(strict_types=1);

namespace Partitura\Service;

use Partitura\Dto\Form\AbstractFormRequestDto;
use Partitura\Exception\LogicException;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

/**
 * Class CsrfTokenValidationService
 * @package Partitura\Service
 */
class CsrfTokenValidationService
{
    /** @var CsrfTokenManagerInterface */
    protected $csrfTokenManager;

    public function __construct(CsrfTokenManagerInterface $csrfTokenManager)
    {
        $this->csrfTokenManager = $csrfTokenManager;
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
            $requestDto->getCsrfTokenId(),
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
