<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Partitura\Entity\Post;
use Partitura\Entity\PostView;
use Partitura\Entity\User;

final class Version20220708213011 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Creates posts views table.';
    }

    /** {@inheritDoc} */
    public function up(Schema $schema): void
    {
        $this->addSql(sprintf(
            'CREATE TABLE %s (
                ID BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
                POST_ID BIGINT UNSIGNED NOT NULL,
                USER_ID BIGINT UNSIGNED DEFAULT NULL,
                IP_ADDRESS LONGTEXT NOT NULL,
                DATETIME_CREATED DATETIME NOT NULL,
                INDEX IDX_C7066F974C81BBD6 (POST_ID),
                INDEX IDX_C7066F97A0666B6F (USER_ID),
                PRIMARY KEY(ID)
            )
            DEFAULT CHARACTER SET utf8mb4
            COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB',
            PostView::TABLE_NAME
        ));
        $this->addSql(sprintf(
            'ALTER TABLE %s
                ADD CONSTRAINT FK_C7066F974C81BBD6 FOREIGN KEY (POST_ID) REFERENCES %s (ID)',
            PostView::TABLE_NAME,
            Post::TABLE_NAME
        ));
        $this->addSql(sprintf(
            'ALTER TABLE %s
                ADD CONSTRAINT FK_C7066F97A0666B6F FOREIGN KEY (USER_ID) REFERENCES %s (ID)',
            PostView::TABLE_NAME,
            User::TABLE_NAME
        ));
    }

    /** {@inheritDoc} */
    public function down(Schema $schema): void
    {
        $this->addSql(sprintf('DROP TABLE %s', PostView::TABLE_NAME));
    }
}
