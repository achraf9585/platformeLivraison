<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190530004915 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE commande_article (id INT AUTO_INCREMENT NOT NULL, commande_id INT DEFAULT NULL, article_id INT DEFAULT NULL, qte INT NOT NULL, INDEX IDX_F4817CC682EA2E54 (commande_id), INDEX IDX_F4817CC67294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE commande_article ADD CONSTRAINT FK_F4817CC682EA2E54 FOREIGN KEY (commande_id) REFERENCES commande (id)');
        $this->addSql('ALTER TABLE commande_article ADD CONSTRAINT FK_F4817CC67294869C FOREIGN KEY (article_id) REFERENCES article (id)');
        $this->addSql('ALTER TABLE livreur CHANGE numtel2 numtel2 VARCHAR(8) NOT NULL, CHANGE disponibilite disponibilite VARCHAR(180) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE commande_article');
        $this->addSql('ALTER TABLE livreur CHANGE numtel2 numtel2 VARCHAR(8) DEFAULT NULL COLLATE utf8mb4_unicode_ci, CHANGE disponibilite disponibilite VARCHAR(180) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
    }
}
