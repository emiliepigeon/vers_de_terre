<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240902154101 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add meta_description and meta_keywords columns to article table';
    }

    public function up(Schema $schema): void
    {
        // Add meta_description and meta_keywords columns
        $this->addSql('ALTER TABLE article ADD meta_description VARCHAR(255) DEFAULT NULL, ADD meta_keywords VARCHAR(255) DEFAULT NULL');
        
        // Optionnel : Mettre à jour les colonnes avec des valeurs par défaut
        $this->addSql("UPDATE article SET meta_description = 'Aucune description fournie' WHERE meta_description IS NULL");
        $this->addSql("UPDATE article SET meta_keywords = 'Aucun mot-clé' WHERE meta_keywords IS NULL");
    }

    public function down(Schema $schema): void
    {
        // Drop the columns if the migration is rolled back
        $this->addSql('ALTER TABLE article DROP meta_description, DROP meta_keywords');
    }
}
