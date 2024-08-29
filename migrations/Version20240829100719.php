<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: This migration adds a 'slug' column to the 'category' table.
 */
final class Version20240829100719 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Adds a slug column to the category table for SEO-friendly URLs.';
    }

    public function up(Schema $schema): void
    {
        // This method is executed when the migration is applied
        // Adding a new column 'slug' to the 'category' table
        $this->addSql('ALTER TABLE category ADD slug VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // This method is executed when the migration is reverted
        // Dropping the 'slug' column from the 'category' table
        $this->addSql('ALTER TABLE category DROP slug');
    }
}
