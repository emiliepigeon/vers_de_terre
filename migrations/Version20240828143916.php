<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240828143916 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE about ADD title1 VARCHAR(255) NOT NULL, ADD content1 LONGTEXT NOT NULL, ADD title2 VARCHAR(255) NOT NULL, ADD content2 LONGTEXT NOT NULL, ADD title3 VARCHAR(255) NOT NULL, ADD content3 LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE about DROP title1, DROP content1, DROP title2, DROP content2, DROP title3, DROP content3');
    }
}
