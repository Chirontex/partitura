<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20220611143326 extends AbstractMigration
{
    /** {@inheritDoc} */
    public function getDescription(): string
    {
        return "Add IN_BLOG flag to post entity.";
    }

    /** {@inheritDoc} */
    public function up(Schema $schema): void
    {
        $this->addSql(
            'ALTER TABLE pt_posts
                ADD IN_BLOG SMALLINT DEFAULT 1 NOT NULL'
        );
    }

    /** {@inheritDoc} */
    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE pt_posts DROP IN_BLOG');
    }
}
