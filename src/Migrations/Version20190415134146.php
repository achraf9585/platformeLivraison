<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190415134146 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE livreur ADD nom VARCHAR(180) NOT NULL, ADD prenom VARCHAR(180) NOT NULL, ADD numtel1 VARCHAR(8) NOT NULL, ADD numtel2 VARCHAR(8) NOT NULL, ADD etat VARCHAR(180) NOT NULL, ADD commission DOUBLE PRECISION NOT NULL, ADD typevehicule VARCHAR(180) NOT NULL, ADD typepapier VARCHAR(180) NOT NULL, ADD numpapier VARCHAR(180) NOT NULL, ADD localisation VARCHAR(180) NOT NULL, ADD disponibilite VARCHAR(180) NOT NULL, ADD datenaissance DATE NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE livreur DROP nom, DROP prenom, DROP numtel1, DROP numtel2, DROP etat, DROP commission, DROP typevehicule, DROP typepapier, DROP numpapier, DROP localisation, DROP disponibilite, DROP datenaissance');
    }
}
