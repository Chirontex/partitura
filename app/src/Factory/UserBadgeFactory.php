<?php
declare(strict_types=1);

namespace Partitura\Factory;

use Doctrine\Persistence\ManagerRegistry;
use Partitura\Dto\AuthenticationDto;
use Partitura\Entity\User;
use Partitura\Exception\AuthenticationException;
use Partitura\Exception\EntityNotFoundException;
use Partitura\Repository\UserRepository;
use Symfony\Component\Security\Http\Authenticator\Passport\Badge\UserBadge;

/**
 * Class UserBadgeFactory
 * @package Partitura\Factory
 */
class UserBadgeFactory
{
    /** @var UserRepository */
    protected $userRepository;

    public function __construct(ManagerRegistry $registry)
    {
        $this->userRepository = $registry->getRepository(User::class);
    }

    /**
     * @param AuthenticationDto $authenticationDto
     *
     * @return UserBadge
     */
    public function createUserBadge(AuthenticationDto $authenticationDto) : UserBadge
    {
        return new UserBadge(
            $authenticationDto->getUsername(),
            function (string $username) : User {
                try {
                    return $this->userRepository->findByUsername($username);
                } catch (EntityNotFoundException $e) {
                    throw new AuthenticationException($e->getMessage(), 0, $e);
                }
            }
        );
    }
}
