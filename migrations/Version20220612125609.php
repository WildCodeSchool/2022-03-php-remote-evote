<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220612125609 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE college (id INT AUTO_INCREMENT NOT NULL, company_id INT DEFAULT NULL, name VARCHAR(155) DEFAULT NULL, description LONGTEXT DEFAULT NULL, vote_percentage DOUBLE PRECISION DEFAULT NULL, INDEX IDX_AADA8702979B1AD6 (company_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE college ADD CONSTRAINT FK_AADA8702979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE voter ADD college_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE voter ADD CONSTRAINT FK_268C4A59770124B2 FOREIGN KEY (college_id) REFERENCES college (id)');
        $this->addSql('CREATE INDEX IDX_268C4A59770124B2 ON voter (college_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE voter DROP FOREIGN KEY FK_268C4A59770124B2');
        $this->addSql('DROP TABLE college');
        $this->addSql('DROP INDEX IDX_268C4A59770124B2 ON voter');
        $this->addSql('ALTER TABLE voter DROP college_id');
    }
}
