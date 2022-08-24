<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220824140439 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE `admin` (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, contact VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, hash VARCHAR(255) NOT NULL, avatar VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demande (id INT AUTO_INCREMENT NOT NULL, localisation_id INT NOT NULL, created_at DATETIME NOT NULL, description VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, INDEX IDX_2694D7A5C68BE09C (localisation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, equipement_id INT NOT NULL, title VARCHAR(255) NOT NULL, attachement VARCHAR(255) NOT NULL, INDEX IDX_D8698A76806F0F5C (equipement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE equipement (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, maker VARCHAR(255) NOT NULL, origin VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, picture VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intervention (id INT AUTO_INCREMENT NOT NULL, demande_id INT NOT NULL, created_at DATETIME NOT NULL, planned_at DATETIME NOT NULL, started_at DATETIME NOT NULL, finished_at DATETIME NOT NULL, comment VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, INDEX IDX_D11814AB80E95E18 (demande_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE intervention_tech (intervention_id INT NOT NULL, tech_id INT NOT NULL, INDEX IDX_890328D08EAE3863 (intervention_id), INDEX IDX_890328D064727BFC (tech_id), PRIMARY KEY(intervention_id, tech_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE localisation (id INT AUTO_INCREMENT NOT NULL, equipement_id INT NOT NULL, service_id INT NOT NULL, created_at DATETIME NOT NULL, used_at DATETIME NOT NULL, state VARCHAR(255) NOT NULL, INDEX IDX_BFD3CE8F806F0F5C (equipement_id), INDEX IDX_BFD3CE8FED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE organe (id INT AUTO_INCREMENT NOT NULL, equipement_id INT NOT NULL, name VARCHAR(255) NOT NULL, picture VARCHAR(255) NOT NULL, INDEX IDX_E23012D0806F0F5C (equipement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE piece (id INT AUTO_INCREMENT NOT NULL, organe_id INT NOT NULL, name VARCHAR(255) NOT NULL, ref VARCHAR(255) NOT NULL, amount INT NOT NULL, INDEX IDX_44CA0B23B5E5B09D (organe_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, site_id INT NOT NULL, name VARCHAR(255) NOT NULL, INDEX IDX_E19D9AD2F6BD1646 (site_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE site (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, picture VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE super_admin (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, contact VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, hash VARCHAR(255) NOT NULL, avatar VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE tech (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, speciality VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, contact VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, hash VARCHAR(255) NOT NULL, avatar VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, site_id INT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, address VARCHAR(255) NOT NULL, contact VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, hash VARCHAR(255) NOT NULL, avatar VARCHAR(255) NOT NULL, INDEX IDX_8D93D649F6BD1646 (site_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE demande ADD CONSTRAINT FK_2694D7A5C68BE09C FOREIGN KEY (localisation_id) REFERENCES localisation (id)');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76806F0F5C FOREIGN KEY (equipement_id) REFERENCES equipement (id)');
        $this->addSql('ALTER TABLE intervention ADD CONSTRAINT FK_D11814AB80E95E18 FOREIGN KEY (demande_id) REFERENCES demande (id)');
        $this->addSql('ALTER TABLE intervention_tech ADD CONSTRAINT FK_890328D08EAE3863 FOREIGN KEY (intervention_id) REFERENCES intervention (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE intervention_tech ADD CONSTRAINT FK_890328D064727BFC FOREIGN KEY (tech_id) REFERENCES tech (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE localisation ADD CONSTRAINT FK_BFD3CE8F806F0F5C FOREIGN KEY (equipement_id) REFERENCES equipement (id)');
        $this->addSql('ALTER TABLE localisation ADD CONSTRAINT FK_BFD3CE8FED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE organe ADD CONSTRAINT FK_E23012D0806F0F5C FOREIGN KEY (equipement_id) REFERENCES equipement (id)');
        $this->addSql('ALTER TABLE piece ADD CONSTRAINT FK_44CA0B23B5E5B09D FOREIGN KEY (organe_id) REFERENCES organe (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2F6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649F6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande DROP FOREIGN KEY FK_2694D7A5C68BE09C');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76806F0F5C');
        $this->addSql('ALTER TABLE intervention DROP FOREIGN KEY FK_D11814AB80E95E18');
        $this->addSql('ALTER TABLE intervention_tech DROP FOREIGN KEY FK_890328D08EAE3863');
        $this->addSql('ALTER TABLE intervention_tech DROP FOREIGN KEY FK_890328D064727BFC');
        $this->addSql('ALTER TABLE localisation DROP FOREIGN KEY FK_BFD3CE8F806F0F5C');
        $this->addSql('ALTER TABLE localisation DROP FOREIGN KEY FK_BFD3CE8FED5CA9E6');
        $this->addSql('ALTER TABLE organe DROP FOREIGN KEY FK_E23012D0806F0F5C');
        $this->addSql('ALTER TABLE piece DROP FOREIGN KEY FK_44CA0B23B5E5B09D');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2F6BD1646');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649F6BD1646');
        $this->addSql('DROP TABLE `admin`');
        $this->addSql('DROP TABLE demande');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE equipement');
        $this->addSql('DROP TABLE intervention');
        $this->addSql('DROP TABLE intervention_tech');
        $this->addSql('DROP TABLE localisation');
        $this->addSql('DROP TABLE organe');
        $this->addSql('DROP TABLE piece');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE site');
        $this->addSql('DROP TABLE super_admin');
        $this->addSql('DROP TABLE tech');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
