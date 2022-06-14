<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220613101803 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE proxy_for (id INT AUTO_INCREMENT NOT NULL, voter_id INT DEFAULT NULL, name VARCHAR(155) DEFAULT NULL, INDEX IDX_15C8BF96EBB4B8AD (voter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE proxy_for ADD CONSTRAINT FK_15C8BF96EBB4B8AD FOREIGN KEY (voter_id) REFERENCES voter (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE proxy_for');
    }
}
