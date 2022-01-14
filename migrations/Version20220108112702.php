<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220108112702 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reply ADD commenter_id INT NOT NULL');
        $this->addSql('ALTER TABLE reply ADD CONSTRAINT FK_FDA8C6E0B4D5A9E2 FOREIGN KEY (commenter_id) REFERENCES commenter (id)');
        $this->addSql('CREATE INDEX IDX_FDA8C6E0B4D5A9E2 ON reply (commenter_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reply DROP FOREIGN KEY FK_FDA8C6E0B4D5A9E2');
        $this->addSql('DROP INDEX IDX_FDA8C6E0B4D5A9E2 ON reply');
        $this->addSql('ALTER TABLE reply DROP commenter_id');
    }
}
