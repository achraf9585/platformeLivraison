<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190415133714 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE livreur ADD roles JSON NOT NULL, ADD password VARCHAR(255) NOT NULL, DROP nom, DROP prenom, DROP motdepasse, DROP numtel1, DROP numtel2, DROP etat, DROP commission, DROP typevehicule, DROP numpapier, DROP typepapier, DROP localisation, DROP disponible, DROP datenaissance, CHANGE email email VARCHAR(180) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EB7A4E6DE7927C74 ON livreur (email)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP INDEX UNIQ_EB7A4E6DE7927C74 ON livreur');
        $this->addSql('ALTER TABLE livreur ADD prenom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD motdepasse VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD numtel1 VARCHAR(8) NOT NULL COLLATE utf8mb4_unicode_ci, ADD numtel2 VARCHAR(8) DEFAULT NULL COLLATE utf8mb4_unicode_ci, ADD etat VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD commission DOUBLE PRECISION NOT NULL, ADD typevehicule VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD numpapier VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD typepapier VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD localisation VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD disponible VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD datenaissance DATE NOT NULL, DROP roles, CHANGE email email VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, CHANGE password nom VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
    }
}
