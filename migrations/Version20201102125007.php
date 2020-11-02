<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201102125007 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE administrator ADD passwordAdmin VARCHAR(25) NOT NULL, DROP password');
        $this->addSql('ALTER TABLE article CHANGE idCategorie idCategorie INT DEFAULT NULL, CHANGE idAdmin idAdmin INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comment CHANGE idArticle idArticle INT DEFAULT NULL, CHANGE idUser idUser INT DEFAULT NULL');
        $this->addSql('ALTER TABLE post CHANGE idTopics idTopics INT DEFAULT NULL, CHANGE idUser idUser INT DEFAULT NULL');
        $this->addSql('ALTER TABLE topics CHANGE idCategorie idCategorie INT DEFAULT NULL, CHANGE idUser idUser INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user DROP avatar, CHANGE password password VARCHAR(25) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE administrator ADD password VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`, DROP passwordAdmin');
        $this->addSql('ALTER TABLE article CHANGE idAdmin idAdmin INT NOT NULL, CHANGE idCategorie idCategorie INT NOT NULL');
        $this->addSql('ALTER TABLE comment CHANGE idArticle idArticle INT NOT NULL, CHANGE idUser idUser INT NOT NULL');
        $this->addSql('ALTER TABLE post CHANGE idTopics idTopics INT NOT NULL, CHANGE idUser idUser INT NOT NULL');
        $this->addSql('ALTER TABLE topics CHANGE idCategorie idCategorie INT NOT NULL, CHANGE idUser idUser INT NOT NULL');
        $this->addSql('ALTER TABLE user ADD avatar VARCHAR(25) CHARACTER SET utf8 DEFAULT NULL COLLATE `utf8_general_ci`, CHANGE password password VARCHAR(255) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`');
    }
}
