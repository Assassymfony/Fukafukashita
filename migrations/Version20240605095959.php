<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240605095959 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tag (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, color VARCHAR(255) DEFAULT NULL)');
        $this->addSql('CREATE TABLE tag_post (tag_id INTEGER NOT NULL, post_id INTEGER NOT NULL, PRIMARY KEY(tag_id, post_id), CONSTRAINT FK_B485D33BBAD26311 FOREIGN KEY (tag_id) REFERENCES tag (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_B485D33B4B89032C FOREIGN KEY (post_id) REFERENCES post (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_B485D33BBAD26311 ON tag_post (tag_id)');
        $this->addSql('CREATE INDEX IDX_B485D33B4B89032C ON tag_post (post_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__commentary AS SELECT id, text FROM commentary');
        $this->addSql('DROP TABLE commentary');
        $this->addSql('CREATE TABLE commentary (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, profil_id INTEGER NOT NULL, post_id INTEGER NOT NULL, text VARCHAR(255) DEFAULT NULL, CONSTRAINT FK_1CAC12CA275ED078 FOREIGN KEY (profil_id) REFERENCES profil (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_1CAC12CA4B89032C FOREIGN KEY (post_id) REFERENCES post (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO commentary (id, text) SELECT id, text FROM __temp__commentary');
        $this->addSql('DROP TABLE __temp__commentary');
        $this->addSql('CREATE INDEX IDX_1CAC12CA275ED078 ON commentary (profil_id)');
        $this->addSql('CREATE INDEX IDX_1CAC12CA4B89032C ON commentary (post_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__post AS SELECT id, title, text, is_dream, up_vote, down_vote FROM post');
        $this->addSql('DROP TABLE post');
        $this->addSql('CREATE TABLE post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, profil_id INTEGER NOT NULL, title VARCHAR(255) DEFAULT NULL, text CLOB DEFAULT NULL, is_dream BOOLEAN NOT NULL, up_vote INTEGER NOT NULL, down_vote INTEGER NOT NULL, CONSTRAINT FK_5A8A6C8D275ED078 FOREIGN KEY (profil_id) REFERENCES profil (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO post (id, title, text, is_dream, up_vote, down_vote) SELECT id, title, text, is_dream, up_vote, down_vote FROM __temp__post');
        $this->addSql('DROP TABLE __temp__post');
        $this->addSql('CREATE INDEX IDX_5A8A6C8D275ED078 ON post (profil_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE tag');
        $this->addSql('DROP TABLE tag_post');
        $this->addSql('CREATE TEMPORARY TABLE __temp__commentary AS SELECT id, text FROM commentary');
        $this->addSql('DROP TABLE commentary');
        $this->addSql('CREATE TABLE commentary (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, text VARCHAR(255) DEFAULT NULL)');
        $this->addSql('INSERT INTO commentary (id, text) SELECT id, text FROM __temp__commentary');
        $this->addSql('DROP TABLE __temp__commentary');
        $this->addSql('CREATE TEMPORARY TABLE __temp__post AS SELECT id, title, text, is_dream, up_vote, down_vote FROM post');
        $this->addSql('DROP TABLE post');
        $this->addSql('CREATE TABLE post (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, title VARCHAR(255) DEFAULT NULL, text CLOB DEFAULT NULL, is_dream BOOLEAN NOT NULL, up_vote INTEGER NOT NULL, down_vote INTEGER NOT NULL)');
        $this->addSql('INSERT INTO post (id, title, text, is_dream, up_vote, down_vote) SELECT id, title, text, is_dream, up_vote, down_vote FROM __temp__post');
        $this->addSql('DROP TABLE __temp__post');
    }
}
