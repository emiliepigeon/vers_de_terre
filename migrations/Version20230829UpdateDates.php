<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20230829UpdateDates extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $this->addSql('UPDATE article SET created_at = NOW(), updated_at = NOW() WHERE created_at IS NULL OR created_at = "0000-00-00 00:00:00"');
    }

    public function down(Schema $schema): void
    {
        // No down migration needed
    }
}
