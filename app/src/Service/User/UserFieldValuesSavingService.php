<?php
declare(strict_types=1);

namespace Partitura\Service\User;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Persistence\ObjectManager;
use Partitura\Entity\User;
use Partitura\Entity\UserField;
use Partitura\Entity\UserFieldValue;
use Partitura\Exception\EntityNotFoundException;
use Partitura\Factory\UserFieldValueFactory;
use Partitura\Repository\UserFieldRepository;

/**
 * Class UserFieldValuesSavingService
 * @package Partitura\Service\User
 */
class UserFieldValuesSavingService
{
    protected ObjectManager $objectManager;

    protected UserFieldRepository $userFieldRepository;

    public function __construct(
        ManagerRegistry $registry,
        protected UserFieldValueFactory $userFieldValueFactory
    ) {
        $this->objectManager = $registry->getManager();
        $this->userFieldRepository = $registry->getRepository(UserField::class);
    }

    /**
     * @param User $user
     * @param ArrayCollection<string, mixed> $newValues
     * 
     * @throws EntityNotFoundException
     */
    public function saveFromCollection(User $user, ArrayCollection $newValues) : void
    {
        $existUserFieldValues = $user->getAdditionalFields();
        $userFields = $this->getUserFields($existUserFieldValues, $newValues);

        foreach ($newValues as $userFieldCode => $value) {
            if ($existUserFieldValues !== null) {
                $existUserFieldValue = $this->findExistUserFieldValueByCode(
                    $existUserFieldValues,
                    $userFieldCode
                );

                if ($existUserFieldValue !== null) {
                    $existUserFieldValue->setValue(trim((string)$value));

                    continue;
                }
            }

            $userField = $userFields->get($userFieldCode);

            if ($userField === null) {
                throw new EntityNotFoundException(sprintf(
                    "User field with code \"%s\" was not found.",
                    $userFieldCode
                ));
            }

            $this->objectManager->persist(
                $this->userFieldValueFactory->create($userField, $user, (string)$value)
            );
        }

        $this->objectManager->flush();
    }

    /**
     * @param null|PersistentCollection<UserFieldValue> $existUserFieldValues
     * @param ArrayCollection<string, mixed> $newValues
     *
     * @return ArrayCollection<string, UserField>
     */
    protected function getUserFields(?PersistentCollection $existUserFieldValues, ArrayCollection $newValues) : ArrayCollection
    {
        /** @var string[] */
        $userFieldCodes = $newValues->getKeys();
        $involvedUserFields = [];

        if ($existUserFieldValues !== null) {
            foreach ($existUserFieldValues as $userFieldValue) {
                $userField = $userFieldValue->getField();
                $involvedUserFields[] = $userField;
                $i = array_search($userField->getCode(), $userFieldCodes, true);

                if ($i !== false) {
                    unset($userFieldCodes[$i]);
                }
            }
        }

        $newUserFields = $this->userFieldRepository->findBy(["code" => $userFieldCodes]);

        /** @var UserField[] */
        $userFields = array_merge($involvedUserFields, $newUserFields->getValues());
        $result = new ArrayCollection();

        foreach ($userFields as $userField) {
            $result->set($userField->getCode(), $userField);
        }

        return $result;
    }

    /**
     * @param PersistentCollection<UserFieldValue> $existUserFieldValues
     * @param string $userFieldCode
     *
     * @return null|UserFieldValue
     */
    protected function findExistUserFieldValueByCode(
        PersistentCollection $existUserFieldValues,
        string $userFieldCode
    ) : ?UserFieldValue {
        foreach ($existUserFieldValues as $userFieldValue) {
            $userField = $userFieldValue->getField();

            if ($userField->getCode() === $userFieldCode) {
                return $userFieldValue;
            }
        }

        return null;
    }
}
