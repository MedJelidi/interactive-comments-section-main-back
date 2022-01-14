<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220108101109 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, commenter_id INT NOT NULL, content VARCHAR(255) NOT NULL, created_at VARCHAR(255) NOT NULL, score INT NOT NULL, INDEX IDX_9474526CB4D5A9E2 (commenter_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE commenter (id INT AUTO_INCREMENT NOT NULL, image_id INT DEFAULT NULL, username VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_AB751D0A3DA5256D (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, png VARCHAR(255) NOT NULL, webp VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reply (id INT AUTO_INCREMENT NOT NULL, comment_id INT DEFAULT NULL, content VARCHAR(255) NOT NULL, created_at VARCHAR(255) NOT NULL, score INT NOT NULL, replying_to VARCHAR(255) NOT NULL, INDEX IDX_FDA8C6E0F8697D13 (comment_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CB4D5A9E2 FOREIGN KEY (commenter_id) REFERENCES commenter (id)');
        $this->addSql('ALTER TABLE commenter ADD CONSTRAINT FK_AB751D0A3DA5256D FOREIGN KEY (image_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE reply ADD CONSTRAINT FK_FDA8C6E0F8697D13 FOREIGN KEY (comment_id) REFERENCES comment (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reply DROP FOREIGN KEY FK_FDA8C6E0F8697D13');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CB4D5A9E2');
        $this->addSql('ALTER TABLE commenter DROP FOREIGN KEY FK_AB751D0A3DA5256D');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE commenter');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE reply');
    }
}
