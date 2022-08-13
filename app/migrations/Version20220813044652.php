<?php
declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Partitura\Entity\User;
use Partitura\Entity\UserField;
use Partitura\Entity\UserFieldValue;

final class Version20220813044652 extends AbstractMigration
{
    /** {@inheritDoc} */
    public function getDescription(): string
    {
        return 'Creates user field values table.';
    }

    /** {@inheritDoc} */
    public function up(Schema $schema): void
    {
        $this->addSql(sprintf(
            'CREATE TABLE %s (
                ID BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
                USER_ID BIGINT UNSIGNED NOT NULL,
                FIELD_ID BIGINT UNSIGNED NOT NULL,
                VALUE LONGTEXT NOT NULL,
                INDEX IDX_FFCFD502A0666B6F (USER_ID),
                INDEX IDX_FFCFD502BA49DD1C (FIELD_ID),
                PRIMARY KEY(ID)
            )
            DEFAULT CHARACTER SET utf8mb4
            COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB',
            UserFieldValue::TABLE_NAME
        ));
        $this->addSql(sprintf(
            'ALTER TABLE %s
                ADD CONSTRAINT FK_FFCFD502A0666B6F FOREIGN KEY (USER_ID) REFERENCES %s (ID)',
            UserFieldValue::TABLE_NAME,
            User::TABLE_NAME
        ));
        $this->addSql(sprintf(
            'ALTER TABLE %s
                ADD CONSTRAINT FK_FFCFD502BA49DD1C FOREIGN KEY (FIELD_ID) REFERENCES %s (ID)',
            UserFieldValue::TABLE_NAME,
            UserField::TABLE_NAME
        ));
    }

    /** {@inheritDoc} */
    public function down(Schema $schema): void
    {
        $this->addSql(sprintf('DROP TABLE %s', UserFieldValue::TABLE_NAME));
    }
}
