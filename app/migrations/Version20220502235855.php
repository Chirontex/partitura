<?php
declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Doctrine\Persistence\ManagerRegistry;
use Partitura\Entity\Role;
use Partitura\Entity\RoleUnitReference;
use Partitura\Entity\Unit;
use Partitura\Entity\User;
use Partitura\Enum\RoleEnum;
use Partitura\Kernel;

final class Version20220502235855 extends AbstractMigration
{
    /** {@inheritDoc} */
    public function getDescription() : string
    {
        return "Add users, roles, units and role-unit-references.";
    }

    /** {@inheritDoc} */
    public function up(Schema $schema) : void
    {
        $this->addSql(sprintf(
            'CREATE TABLE %s (
                ID BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
                CODE VARCHAR(180) NOT NULL,
                `NAME` VARCHAR(180) NOT NULL,
                UNIQUE INDEX UNIQ_5C91D9394180DD2C (CODE),
                PRIMARY KEY(ID)
            )
            DEFAULT CHARACTER SET utf8mb4
            COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB',
            Role::TABLE_NAME
        ));
        $this->addSql(sprintf(
            'CREATE TABLE %s (
                ID BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
                CODE VARCHAR(180) NOT NULL,
                UNIQUE INDEX UNIQ_31F83B74180DD2C (CODE),
                PRIMARY KEY(ID)
            )
            DEFAULT CHARACTER SET utf8mb4
            COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB',
            Unit::TABLE_NAME
        ));
        $this->addSql(sprintf(
            'CREATE TABLE %s (
                ROLE_ID BIGINT UNSIGNED NOT NULL,
                UNIT_ID BIGINT UNSIGNED NOT NULL,
                INDEX IDX_6CDA33ADD10B9A56 (ROLE_ID),
                INDEX IDX_6CDA33ADFFB5C8F7 (UNIT_ID),
                PRIMARY KEY(ROLE_ID, UNIT_ID)
            )
            DEFAULT CHARACTER SET utf8mb4
            COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB',
            RoleUnitReference::TABLE_NAME
        ));
        $this->addSql(sprintf(
            'CREATE TABLE %s (
                ID BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
                USERNAME VARCHAR(180) NOT NULL,
                PASSWORD_HASH VARCHAR(180) NOT NULL,
                ROLE_ID BIGINT UNSIGNED DEFAULT NULL,
                ACTIVE SMALLINT DEFAULT 1 NOT NULL,
                DATETIME_CREATED DATETIME NOT NULL,
                DATETIME_UPDATED DATETIME DEFAULT NULL,
                UNIQUE INDEX UNIQ_FE2C52173E6D9A3B (USERNAME),
                INDEX IDX_FE2C5217D10B9A56 (ROLE_ID),
                PRIMARY KEY(ID)
            )
            DEFAULT CHARACTER SET utf8mb4
            COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB',
            User::TABLE_NAME
        ));
        $this->addSql(
            'CREATE TABLE messenger_messages (
                id BIGINT AUTO_INCREMENT NOT NULL,
                body LONGTEXT NOT NULL,
                headers LONGTEXT NOT NULL,
                queue_name VARCHAR(190) NOT NULL,
                created_at DATETIME NOT NULL,
                available_at DATETIME NOT NULL,
                delivered_at DATETIME DEFAULT NULL,
                INDEX IDX_75EA56E0FB7336F0 (queue_name),
                INDEX IDX_75EA56E0E3BD61CE (available_at),
                INDEX IDX_75EA56E016BA31DB (delivered_at),
                PRIMARY KEY(id)
            )
            DEFAULT CHARACTER SET utf8mb4
            COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(
            'CREATE TABLE rememberme_token (
                series VARCHAR(88) NOT NULL,
                value VARCHAR(88) NOT NULL,
                lastUsed DATETIME NOT NULL,
                class VARCHAR(100) NOT NULL,
                username VARCHAR(200) NOT NULL,
                PRIMARY KEY(series)
            )
            DEFAULT CHARACTER SET utf8mb4
            COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB'
        );
        $this->addSql(sprintf(
            'ALTER TABLE %s
                ADD CONSTRAINT FK_6CDA33ADD10B9A56 FOREIGN KEY (ROLE_ID) REFERENCES %s (ID)',
            RoleUnitReference::TABLE_NAME,
            Role::TABLE_NAME
        ));
        $this->addSql(sprintf(
            'ALTER TABLE %s
                ADD CONSTRAINT FK_6CDA33ADFFB5C8F7 FOREIGN KEY (UNIT_ID) REFERENCES %s (ID)',
            RoleUnitReference::TABLE_NAME,
            Unit::TABLE_NAME
        ));
        $this->addSql(sprintf(
            'ALTER TABLE %s
                ADD CONSTRAINT FK_FE2C5217D10B9A56 FOREIGN KEY (ROLE_ID) REFERENCES %s (ID)',
            User::TABLE_NAME,
            Role::TABLE_NAME
        ));
    }

    /** {@inheritDoc} */
    public function postUp(Schema $schema) : void
    {
        /** @var ManagerRegistry */
        $registry = Kernel::getInstance()->getService("doctrine");
        $objectManager = $registry->getManager();
        
        foreach (RoleEnum::cases() as $role) {
            $objectManager->persist(
                (new Role())
                    ->setCode($role->value)
                    ->setName($role->getName())
            );
        }

        $objectManager->flush();
    }

    /** {@inheritDoc} */
    public function down(Schema $schema) : void
    {
        $this->addSql(sprintf('ALTER TABLE %s DROP FOREIGN KEY FK_6CDA33ADD10B9A56', RoleUnitReference::TABLE_NAME));
        $this->addSql(sprintf('ALTER TABLE %s DROP FOREIGN KEY FK_FE2C5217D10B9A56', User::TABLE_NAME));
        $this->addSql(sprintf('ALTER TABLE %s DROP FOREIGN KEY FK_6CDA33ADFFB5C8F7', RoleUnitReference::TABLE_NAME));
        $this->addSql(sprintf('DROP TABLE %s', RoleUnitReference::TABLE_NAME));
        $this->addSql(sprintf('DROP TABLE %s', Role::TABLE_NAME));
        $this->addSql(sprintf('DROP TABLE %s', Unit::TABLE_NAME));
        $this->addSql(sprintf('DROP TABLE %s', User::TABLE_NAME));
        $this->addSql('DROP TABLE messenger_messages');
        $this->addSql('DROP TABLE rememberme_token');
    }
}
