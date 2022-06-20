<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220615151902 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE voter ADD campaign_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE voter ADD CONSTRAINT FK_268C4A59F639F774 FOREIGN KEY (campaign_id) REFERENCES campaign (id)');
        $this->addSql('CREATE INDEX IDX_268C4A59F639F774 ON voter (campaign_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE voter DROP FOREIGN KEY FK_268C4A59F639F774');
        $this->addSql('DROP INDEX IDX_268C4A59F639F774 ON voter');
        $this->addSql('ALTER TABLE voter DROP campaign_id');
    }
}
