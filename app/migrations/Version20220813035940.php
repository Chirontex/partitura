<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Partitura\Entity\UserField;

final class Version20220813035940 extends AbstractMigration
{
    /** {@inheritDoc} */
    public function getDescription(): string
    {
        return 'Create user fields table.';
    }

    /** {@inheritDoc} */
    public function up(Schema $schema): void
    {
        $this->addSql(sprintf(
            'CREATE TABLE %s (
                ID BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
                CODE VARCHAR(180) NOT NULL,
                UNIQUE INDEX UNIQ_7F4650B44180DD2C (CODE),
                PRIMARY KEY(ID)
            )
            DEFAULT CHARACTER SET utf8mb4
            COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB',
            UserField::TABLE_NAME
        ));
    }

    /** {@inheritDoc} */
    public function down(Schema $schema): void
    {
        $this->addSql(sprintf('DROP TABLE %s', UserField::TABLE_NAME));
    }
}
