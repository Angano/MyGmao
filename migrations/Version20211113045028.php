<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211113045028 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_D11814AB19EB6921');
        $this->addSql('DROP INDEX IDX_D11814AB16880AAF');
        $this->addSql('DROP INDEX IDX_D11814AB13457256');
        $this->addSql('CREATE TEMPORARY TABLE __temp__intervention AS SELECT id, materiel_id, technicien_id, client_id, date, status, symptome, travaux, compteur, date_intervention FROM intervention');
        $this->addSql('DROP TABLE intervention');
        $this->addSql('CREATE TABLE intervention (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, materiel_id INTEGER NOT NULL, technicien_id INTEGER DEFAULT NULL, client_id INTEGER DEFAULT NULL, date DATETIME NOT NULL, status BOOLEAN NOT NULL, symptome CLOB NOT NULL COLLATE BINARY, travaux CLOB DEFAULT NULL COLLATE BINARY, compteur VARCHAR(255) DEFAULT NULL COLLATE BINARY, date_intervention DATE DEFAULT NULL, CONSTRAINT FK_D11814AB16880AAF FOREIGN KEY (materiel_id) REFERENCES materiel (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D11814AB13457256 FOREIGN KEY (technicien_id) REFERENCES technicien (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_D11814AB19EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO intervention (id, materiel_id, technicien_id, client_id, date, status, symptome, travaux, compteur, date_intervention) SELECT id, materiel_id, technicien_id, client_id, date, status, symptome, travaux, compteur, date_intervention FROM __temp__intervention');
        $this->addSql('DROP TABLE __temp__intervention');
        $this->addSql('CREATE INDEX IDX_D11814AB19EB6921 ON intervention (client_id)');
        $this->addSql('CREATE INDEX IDX_D11814AB16880AAF ON intervention (materiel_id)');
        $this->addSql('CREATE INDEX IDX_D11814AB13457256 ON intervention (technicien_id)');
        $this->addSql('DROP INDEX IDX_18D2B091F0A1B127');
        $this->addSql('DROP INDEX IDX_18D2B09119EB6921');
        $this->addSql('CREATE TEMPORARY TABLE __temp__materiel AS SELECT id, materieltype_id, client_id, matricule, infos, compteur FROM materiel');
        $this->addSql('DROP TABLE materiel');
        $this->addSql('CREATE TABLE materiel (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, materieltype_id INTEGER DEFAULT NULL, client_id INTEGER DEFAULT NULL, matricule VARCHAR(255) NOT NULL COLLATE BINARY, infos CLOB DEFAULT NULL COLLATE BINARY, compteur INTEGER NOT NULL, CONSTRAINT FK_18D2B091F0A1B127 FOREIGN KEY (materieltype_id) REFERENCES materieltype (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_18D2B09119EB6921 FOREIGN KEY (client_id) REFERENCES client (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO materiel (id, materieltype_id, client_id, matricule, infos, compteur) SELECT id, materieltype_id, client_id, matricule, infos, compteur FROM __temp__materiel');
        $this->addSql('DROP TABLE __temp__materiel');
        $this->addSql('CREATE INDEX IDX_18D2B091F0A1B127 ON materiel (materieltype_id)');
        $this->addSql('CREATE INDEX IDX_18D2B09119EB6921 ON materiel (client_id)');
        $this->addSql('DROP INDEX UNIQ_96282C4CA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__technicien AS SELECT id, user_id, nom, prenom, metier FROM technicien');
        $this->addSql('DROP TABLE technicien');
        $this->addSql('CREATE TABLE technicien (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, nom VARCHAR(255) NOT NULL COLLATE BINARY, prenom VARCHAR(255) NOT NULL COLLATE BINARY, metier VARCHAR(255) NOT NULL COLLATE BINARY, CONSTRAINT FK_96282C4CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO technicien (id, user_id, nom, prenom, metier) SELECT id, user_id, nom, prenom, metier FROM __temp__technicien');
        $this->addSql('DROP TABLE __temp__technicien');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_96282C4CA76ED395 ON technicien (user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX IDX_D11814AB16880AAF');
        $this->addSql('DROP INDEX IDX_D11814AB13457256');
        $this->addSql('DROP INDEX IDX_D11814AB19EB6921');
        $this->addSql('CREATE TEMPORARY TABLE __temp__intervention AS SELECT id, materiel_id, technicien_id, client_id, date, status, symptome, travaux, compteur, date_intervention FROM intervention');
        $this->addSql('DROP TABLE intervention');
        $this->addSql('CREATE TABLE intervention (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, materiel_id INTEGER NOT NULL, technicien_id INTEGER DEFAULT NULL, client_id INTEGER DEFAULT NULL, date DATETIME NOT NULL, status BOOLEAN NOT NULL, symptome CLOB NOT NULL, travaux CLOB DEFAULT NULL, compteur VARCHAR(255) DEFAULT NULL, date_intervention DATE DEFAULT NULL)');
        $this->addSql('INSERT INTO intervention (id, materiel_id, technicien_id, client_id, date, status, symptome, travaux, compteur, date_intervention) SELECT id, materiel_id, technicien_id, client_id, date, status, symptome, travaux, compteur, date_intervention FROM __temp__intervention');
        $this->addSql('DROP TABLE __temp__intervention');
        $this->addSql('CREATE INDEX IDX_D11814AB16880AAF ON intervention (materiel_id)');
        $this->addSql('CREATE INDEX IDX_D11814AB13457256 ON intervention (technicien_id)');
        $this->addSql('CREATE INDEX IDX_D11814AB19EB6921 ON intervention (client_id)');
        $this->addSql('DROP INDEX IDX_18D2B091F0A1B127');
        $this->addSql('DROP INDEX IDX_18D2B09119EB6921');
        $this->addSql('CREATE TEMPORARY TABLE __temp__materiel AS SELECT id, materieltype_id, client_id, matricule, infos, compteur FROM materiel');
        $this->addSql('DROP TABLE materiel');
        $this->addSql('CREATE TABLE materiel (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, materieltype_id INTEGER DEFAULT NULL, client_id INTEGER DEFAULT NULL, matricule VARCHAR(255) NOT NULL, infos CLOB DEFAULT NULL, compteur INTEGER NOT NULL)');
        $this->addSql('INSERT INTO materiel (id, materieltype_id, client_id, matricule, infos, compteur) SELECT id, materieltype_id, client_id, matricule, infos, compteur FROM __temp__materiel');
        $this->addSql('DROP TABLE __temp__materiel');
        $this->addSql('CREATE INDEX IDX_18D2B091F0A1B127 ON materiel (materieltype_id)');
        $this->addSql('CREATE INDEX IDX_18D2B09119EB6921 ON materiel (client_id)');
        $this->addSql('DROP INDEX UNIQ_96282C4CA76ED395');
        $this->addSql('CREATE TEMPORARY TABLE __temp__technicien AS SELECT id, user_id, nom, prenom, metier FROM technicien');
        $this->addSql('DROP TABLE technicien');
        $this->addSql('CREATE TABLE technicien (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, user_id INTEGER NOT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, metier VARCHAR(255) NOT NULL)');
        $this->addSql('INSERT INTO technicien (id, user_id, nom, prenom, metier) SELECT id, user_id, nom, prenom, metier FROM __temp__technicien');
        $this->addSql('DROP TABLE __temp__technicien');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_96282C4CA76ED395 ON technicien (user_id)');
    }
}
