<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190415114529 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE condi (id INT AUTO_INCREMENT NOT NULL, libele LONGTEXT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE region (id INT AUTO_INCREMENT NOT NULL, libele VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_F62F1767175FC81 (libele), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ville (id INT AUTO_INCREMENT NOT NULL, region_id INT NOT NULL, libele VARCHAR(255) NOT NULL, INDEX IDX_43C3D9C398260155 (region_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE ville ADD CONSTRAINT FK_43C3D9C398260155 FOREIGN KEY (region_id) REFERENCES region (id)');
        $this->addSql('DROP TABLE livreur');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE ville DROP FOREIGN KEY FK_43C3D9C398260155');
        $this->addSql('CREATE TABLE livreur (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, prenom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, email VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, motdepasse VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, numtel1 VARCHAR(8) NOT NULL COLLATE utf8mb4_unicode_ci, numtel2 VARCHAR(8) DEFAULT NULL COLLATE utf8mb4_unicode_ci, commission DOUBLE PRECISION NOT NULL, typevehicule VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, numpapier VARCHAR(20) NOT NULL COLLATE utf8mb4_unicode_ci, typepapier VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, localisation VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, disponibilite VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, etat VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, datenaissance DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE condi');
        $this->addSql('DROP TABLE region');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE ville');
    }
}
