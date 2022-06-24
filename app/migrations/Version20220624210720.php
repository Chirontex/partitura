<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;
use Partitura\Entity\Post;

final class Version20220624210720 extends AbstractMigration
{
    /** {@inheritDoc} */
    public function getDescription(): string
    {
        return 'Add preview field to post entity.';
    }

    /** {@inheritDoc} */
    public function up(Schema $schema): void
    {
        $this->addSql(sprintf('ALTER TABLE %s ADD PREVIEW LONGTEXT NOT NULL', Post::TABLE_NAME));
    }

    /** {@inheritDoc} */
    public function down(Schema $schema): void
    {
        $this->addSql(sprintf('ALTER TABLE %s DROP PREVIEW', Post::TABLE_NAME));
    }
}
