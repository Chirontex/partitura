<?php

declare(strict_types=1);

namespace Partitura\Factory;

use Doctrine\Persistence\ObjectManager;
use Partitura\Dto\AuthenticationDto;
use Partitura\Entity\User;
use Partitura\Exception\EntityNotFoundException;
use Partitura\Exception\InvalidCredentialsException;
use Partitura\Kernel;
use Partitura\Repository\UserRepository;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

/**
 * Class UserBadgeFactory
 */
class UserBadgeFactory
{
    /**
     *
     * @throws InvalidCredentialsException
     */
    public function createUserBadge(AuthenticationDto $authenticationDto): UserBadge
    {
        return new UserBadge(
            $authenticationDto->getUsername(),
            static function (string $username): User {
                /** @var ObjectManager */
                $objectManager = Kernel::getInstance()->getService("doctrine");

                /** @var UserRepository */
                $userRepository = $objectManager->getRepository(User::class);

                try {
                    return $userRepository->findByUsername($username);
                } catch (EntityNotFoundException $e) {
                    throw new InvalidCredentialsException("Invalid credentials.", 0, $e);
                }
            }
        );
    }
}
