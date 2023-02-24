<?php

declare(strict_types=1);

namespace Partitura\Service\User;

use Doctrine\Persistence\ManagerRegistry;
use Partitura\Entity\RememberToken;
use Partitura\Entity\User;
use Partitura\Repository\RememberTokenRepository;

/**
 * Class RememberMeTokensDeletingService
 * @package Partitura\Service\User
 */
class RememberMeTokensDeletingService
{
    protected RememberTokenRepository $rememberTokensRepository;

    public function __construct(protected ManagerRegistry $registry)
    {
        $this->rememberTokensRepository = $registry->getRepository(RememberToken::class);
    }

    /**
     * Vipes out all user remember-me tokens.
     * Note: this method will not flush the changes in ObjectManager.
     *
     * @param User $user
     */
    public function clearAllUserTokens(User $user) : void
    {
        $tokens = $this->rememberTokensRepository->findByUsername($user->getUsername());

        if ($tokens->isEmpty()) {
            return;
        }

        $objectManager = $this->registry->getManager();

        /** @var RememberToken $token */
        foreach ($tokens as $token) {
            $objectManager->remove($token);
        }
    }
}
