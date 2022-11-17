<?php
declare(strict_types=1);

namespace Partitura\Manager;

use Partitura\Dto\Form\Profile\Security\SecurityRequestDto;
use Partitura\Exception\ArgumentException;
use Partitura\Factory\RequestDto\AbstractRequestDtoFactory;
use Partitura\Factory\RequestDto\Form\Profile\Security\ChangePasswordRequestDtoFactory;
use Partitura\Factory\RequestDto\Form\Profile\Security\DropRememberMeTokensRequestDtoFactory;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SecurityRequestDtoFactoryManager
 * @package Partitura\Manager
 */
class SecurityRequestDtoFactoryManager
{
    /** @var AbstractRequestDtoFactory[] */
    protected $factories = [];

    public function __construct(
        ChangePasswordRequestDtoFactory $changePasswordRequestDtoFactory,
        DropRememberMeTokensRequestDtoFactory $dropRememberMeTokensRequestDtoFactory
    ) {
        $this->factories = [
            $changePasswordRequestDtoFactory,
            $dropRememberMeTokensRequestDtoFactory,
        ];
    }

    /**
     * @param Request $request
     *
     * @throws ArgumentException
     * @return SecurityRequestDto
     */
    public function createRequestDto(Request $request) : SecurityRequestDto
    {
        $errors = [];

        foreach ($this->factories as $factory) {
            try {
                return $factory->createFromRequest($request);
            } catch (ArgumentException $e) {
                $errors[$factory::getDtoClass()] = $e->getMessage();
            }
        }

        $message = "";

        foreach ($errors as $dtoClass => $exceptionMessage) {
            if (!empty($message)) {
                $message .= " | ";
            }

            $message .= sprintf("%s: %s", $dtoClass, $exceptionMessage);
        }

        throw new ArgumentException($message);
    }
}
