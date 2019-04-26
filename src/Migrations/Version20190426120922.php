<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190426120922 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article ADD updated_at DATETIME NOT NULL, DROP imag, CHANGE image image_name VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE client CHANGE roles roles JSON NOT NULL');
        $this->addSql('ALTER TABLE livreur CHANGE roles roles JSON NOT NULL, CHANGE numtel2 numtel2 VARCHAR(8) NOT NULL, CHANGE etat etat VARCHAR(180) NOT NULL, CHANGE commission commission DOUBLE PRECISION NOT NULL, CHANGE disponibilite disponibilite VARCHAR(180) NOT NULL');
        $this->addSql('ALTER TABLE ville ADD statut VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE article ADD imag LONGBLOB NOT NULL, DROP updated_at, CHANGE image_name image VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE client CHANGE roles roles JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE livreur CHANGE numtel2 numtel2 VARCHAR(8) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE etat etat VARCHAR(180) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE commission commission DOUBLE PRECISION DEFAULT NULL, CHANGE disponibilite disponibilite VARCHAR(180) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE roles roles JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE ville DROP statut');
    }
}
