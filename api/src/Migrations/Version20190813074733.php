<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190813074733 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE quote ADD owner_id INT NOT NULL');
        $this->addSql('ALTER TABLE quote DROP owner');
        $this->addSql('ALTER TABLE quote ADD CONSTRAINT FK_6B71CBF47E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_6B71CBF47E3C61F9 ON quote (owner_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE quote DROP CONSTRAINT FK_6B71CBF47E3C61F9');
        $this->addSql('DROP INDEX IDX_6B71CBF47E3C61F9');
        $this->addSql('ALTER TABLE quote ADD owner VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE quote DROP owner_id');
    }
}
