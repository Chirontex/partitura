<?php

declare(strict_types=1);

namespace Partitura\Service\User;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Persistence\ManagerRegistry;
use Partitura\Entity\User;
use Partitura\Entity\UserField;
use Partitura\Repository\UserFieldRepository;

/**
 * Class UserFieldValuesGettingService
 */
class UserFieldValuesGettingService
{
    protected UserFieldRepository $userFieldRepository;

    public function __construct(ManagerRegistry $registry)
    {
        $this->userFieldRepository = $registry->getRepository(UserField::class);
    }

    /**
     *
     * @return ArrayCollection<string, string>
     */
    public function getValuesWithEmpty(User $user): ArrayCollection
    {
        $result = new ArrayCollection();
        $userFields = $this->userFieldRepository->findAll();

        foreach ($userFields as $userField) {
            $result->set(
                $userField->getCode(),
                (string)$userField->findValueByUserId($user->getId())?->getValue()
            );
        }

        return $result;
    }
}
