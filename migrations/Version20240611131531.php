<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240611131531 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__post AS SELECT id, profil_id, title, text, is_dream, up_vote, down_vote FROM post');
        $this->addSql('DROP TABLE post');
        $this->addSql('CREATE TABLE post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, profil_id INTEGER NOT NULL, title VARCHAR(255) DEFAULT NULL, text VARCHAR(512) DEFAULT NULL, is_dream BOOLEAN NOT NULL, up_vote INTEGER DEFAULT 0 NOT NULL, down_vote INTEGER DEFAULT 0 NOT NULL, CONSTRAINT FK_5A8A6C8D275ED078 FOREIGN KEY (profil_id) REFERENCES profil (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO post (id, profil_id, title, text, is_dream, up_vote, down_vote) SELECT id, profil_id, title, text, is_dream, up_vote, down_vote FROM __temp__post');
        $this->addSql('DROP TABLE __temp__post');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D275ED078 ON post (profil_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__post AS SELECT id, profil_id, title, text, is_dream, up_vote, down_vote FROM post');
        $this->addSql('DROP TABLE post');
        $this->addSql('CREATE TABLE post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, profil_id INTEGER NOT NULL, title VARCHAR(255) DEFAULT NULL, text VARCHAR(512) DEFAULT NULL, is_dream BOOLEAN NOT NULL, up_vote INTEGER NOT NULL, down_vote INTEGER NOT NULL, CONSTRAINT FK_5A8A6C8D275ED078 FOREIGN KEY (profil_id) REFERENCES profil (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO post (id, profil_id, title, text, is_dream, up_vote, down_vote) SELECT id, profil_id, title, text, is_dream, up_vote, down_vote FROM __temp__post');
        $this->addSql('DROP TABLE __temp__post');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D275ED078 ON post (profil_id)');
    }
}
