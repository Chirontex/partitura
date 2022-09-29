<?php
declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\Persistence\ManagerRegistry;
use Partitura\Entity\UserField;
use Partitura\Enum\UserFieldEnum;
use Partitura\Kernel;
use Partitura\Repository\UserFieldRepository;

final class Version20220930012250 extends AbstractMigration
{
    /** {@inheritDoc} */
    public function getDescription() : string
    {
        return "Add first name and last name user fields.";
    }

    /** {@inheritDoc} */
    public function up(Schema $schema) : void
    {
        /** @var ManagerRegistry */
        $registry = Kernel::getInstance()->getService("doctrine");
        $objectManager = $registry->getManager();
        $userFieldEnumList = $this->getUserFieldEnumList();

        foreach ($userFieldEnumList as $userFieldEnum) {
            $objectManager->persist((new UserField())->setCode($userFieldEnum->value));
        }

        $objectManager->flush();
    }

    /** {@inheritDoc} */
    public function down(Schema $schema) : void
    {
        /** @var ManagerRegistry */
        $registry = Kernel::getInstance()->getService("doctrine");
        $objectManager = $registry->getManager();

        /** @var UserFieldRepository */
        $userFieldRepository = $objectManager->getRepository(UserField::class);
        $codes = array_map(
            static function(UserFieldEnum $userFieldEnum) : string {
                return $userFieldEnum->value;
            },
            $this->getUserFieldEnumList()
        );

        $userFields = $userFieldRepository->findBy(["code" => $codes]);

        foreach ($userFields as $userField) {
            $objectManager->remove($userField);
        }

        $objectManager->flush();
    }

    /**
     * @return UserFieldEnum[]
     */
    protected function getUserFieldEnumList() : array
    {
        return [
            UserFieldEnum::FIRST_NAME,
            UserFieldEnum::LAST_NAME,
        ];
    }
}
