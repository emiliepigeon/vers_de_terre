<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240829135214 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE about CHANGE title1 title1 VARCHAR(255) DEFAULT NULL, CHANGE content1 content1 LONGTEXT DEFAULT NULL, CHANGE title2 title2 VARCHAR(255) DEFAULT NULL, CHANGE content2 content2 LONGTEXT DEFAULT NULL, CHANGE title3 title3 VARCHAR(255) DEFAULT NULL, CHANGE content3 content3 LONGTEXT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE about CHANGE title1 title1 VARCHAR(255) NOT NULL, CHANGE content1 content1 LONGTEXT NOT NULL, CHANGE title2 title2 VARCHAR(255) NOT NULL, CHANGE content2 content2 LONGTEXT NOT NULL, CHANGE title3 title3 VARCHAR(255) NOT NULL, CHANGE content3 content3 LONGTEXT NOT NULL');
    }
}
