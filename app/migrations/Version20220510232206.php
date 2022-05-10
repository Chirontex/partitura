<?php
declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Partitura\Entity\ArchivedPost;
use Partitura\Entity\Post;
use Partitura\Entity\User;

final class Version20220510232206 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add posts and posts archive.';
    }

    /** {@inheritDoc} */
    public function up(Schema $schema): void
    {
        $this->addSql(sprintf(
            'CREATE TABLE %s (
                ID BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
                `NAME` VARCHAR(180) NOT NULL,
                PARENT_ID BIGINT UNSIGNED DEFAULT NULL,
                TITLE VARCHAR(180) NOT NULL,
                CONTENT LONGTEXT NOT NULL,
                AUTHOR_ID BIGINT UNSIGNED NOT NULL,
                LAST_EDITOR_ID BIGINT UNSIGNED NOT NULL,
                TYPE VARCHAR(180) NOT NULL,
                DATETIME_CREATED DATETIME NOT NULL,
                DATETIME_UPDATED DATETIME DEFAULT NULL,
                UNIQUE INDEX UNIQ_62F24D04EF5927F (PARENT_ID),
                INDEX IDX_62F24D048AFAAB14 (AUTHOR_ID),
                INDEX IDX_62F24D04E2624C47 (LAST_EDITOR_ID),
                PRIMARY KEY(ID)
            )
            DEFAULT CHARACTER SET utf8mb4
            COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB',
            Post::TABLE_NAME
        ));
        $this->addSql(sprintf(
            'CREATE TABLE %s (
                ID BIGINT UNSIGNED AUTO_INCREMENT NOT NULL,
                POST_ID BIGINT UNSIGNED NOT NULL,
                TITLE VARCHAR(180) NOT NULL,
                CONTENT LONGTEXT NOT NULL,
                AUTHOR_ID BIGINT UNSIGNED NOT NULL,
                DATETIME_CREATED DATETIME NOT NULL,
                INDEX IDX_BB8A3A9D4C81BBD6 (POST_ID),
                INDEX IDX_BB8A3A9D8AFAAB14 (AUTHOR_ID),
                PRIMARY KEY(ID)
            )
            DEFAULT CHARACTER SET utf8mb4
            COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB',
            ArchivedPost::TABLE_NAME
        ));
        $this->addSql(sprintf(
            'ALTER TABLE %1$s
                ADD CONSTRAINT FK_62F24D04EF5927F FOREIGN KEY (PARENT_ID) REFERENCES %1$s (ID)',
            Post::TABLE_NAME
        ));
        $this->addSql(sprintf(
            'ALTER TABLE %s
                ADD CONSTRAINT FK_62F24D048AFAAB14 FOREIGN KEY (AUTHOR_ID) REFERENCES %s (ID)',
            Post::TABLE_NAME,
            User::TABLE_NAME
        ));
        $this->addSql(sprintf(
            'ALTER TABLE %s
                ADD CONSTRAINT FK_62F24D04E2624C47 FOREIGN KEY (LAST_EDITOR_ID) REFERENCES %s (ID)',
            Post::TABLE_NAME,
            User::TABLE_NAME
        ));
        $this->addSql(sprintf(
            'ALTER TABLE %s
                ADD CONSTRAINT FK_BB8A3A9D4C81BBD6 FOREIGN KEY (POST_ID) REFERENCES %s (ID)',
            ArchivedPost::TABLE_NAME,
            Post::TABLE_NAME
        ));
        $this->addSql(sprintf(
            'ALTER TABLE %s
                ADD CONSTRAINT FK_BB8A3A9D8AFAAB14 FOREIGN KEY (AUTHOR_ID) REFERENCES %s (ID)',
            ArchivedPost::TABLE_NAME,
            User::TABLE_NAME
        ));
    }

    /** {@inheritDoc} */
    public function down(Schema $schema): void
    {
        $this->addSql(sprintf('ALTER TABLE %s DROP FOREIGN KEY FK_62F24D04EF5927F', Post::TABLE_NAME));
        $this->addSql(sprintf('ALTER TABLE pt_posts_archive DROP FOREIGN KEY FK_BB8A3A9D4C81BBD6', ArchivedPost::TABLE_NAME));
        $this->addSql(sprintf('DROP TABLE %s', Post::TABLE_NAME));
        $this->addSql(sprintf('DROP TABLE %s', ArchivedPost::TABLE_NAME));
    }
}
