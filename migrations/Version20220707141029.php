<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220707141029 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE vote (id INT AUTO_INCREMENT NOT NULL, resolution_id INT DEFAULT NULL, voter_id INT DEFAULT NULL, answer VARCHAR(10) DEFAULT NULL, INDEX IDX_5A10856412A1C43A (resolution_id), INDEX IDX_5A108564EBB4B8AD (voter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A10856412A1C43A FOREIGN KEY (resolution_id) REFERENCES resolution (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564EBB4B8AD FOREIGN KEY (voter_id) REFERENCES voter (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE vote');
    }
}
