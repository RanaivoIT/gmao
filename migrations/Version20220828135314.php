<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220828135314 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin ADD job VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE localisation DROP FOREIGN KEY FK_BFD3CE8FED5CA9E6');
        $this->addSql('DROP INDEX IDX_BFD3CE8FED5CA9E6 ON localisation');
        $this->addSql('ALTER TABLE localisation CHANGE service_id site_id INT NOT NULL');
        $this->addSql('ALTER TABLE localisation ADD CONSTRAINT FK_BFD3CE8FF6BD1646 FOREIGN KEY (site_id) REFERENCES site (id)');
        $this->addSql('CREATE INDEX IDX_BFD3CE8FF6BD1646 ON localisation (site_id)');
        $this->addSql('ALTER TABLE user ADD job VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `admin` DROP job');
        $this->addSql('ALTER TABLE localisation DROP FOREIGN KEY FK_BFD3CE8FF6BD1646');
        $this->addSql('DROP INDEX IDX_BFD3CE8FF6BD1646 ON localisation');
        $this->addSql('ALTER TABLE localisation CHANGE site_id service_id INT NOT NULL');
        $this->addSql('ALTER TABLE localisation ADD CONSTRAINT FK_BFD3CE8FED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('CREATE INDEX IDX_BFD3CE8FED5CA9E6 ON localisation (service_id)');
        $this->addSql('ALTER TABLE user DROP job');
    }
}
