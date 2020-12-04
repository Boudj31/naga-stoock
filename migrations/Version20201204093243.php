<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201204093243 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE computer (id INT AUTO_INCREMENT NOT NULL, donor_id INT NOT NULL, received_at DATETIME NOT NULL, serial VARCHAR(255) NOT NULL, status VARCHAR(255) NOT NULL, comment LONGTEXT DEFAULT NULL, type VARCHAR(255) NOT NULL, INDEX IDX_A298A7A63DD7B7A7 (donor_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE member_ship (id INT AUTO_INCREMENT NOT NULL, member_id INT NOT NULL, computer_id INT NOT NULL, type VARCHAR(255) NOT NULL, begin_at DATETIME NOT NULL, comment LONGTEXT DEFAULT NULL, amount INT NOT NULL, INDEX IDX_6B8C7787597D3FE (member_id), UNIQUE INDEX UNIQ_6B8C778A426D518 (computer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE society (id INT AUTO_INCREMENT NOT NULL, adress_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, representative_name VARCHAR(255) DEFAULT NULL, representative_mail VARCHAR(255) DEFAULT NULL, representative_phone VARCHAR(255) DEFAULT NULL, comment LONGTEXT DEFAULT NULL, UNIQUE INDEX UNIQ_D6461F28486F9AC (adress_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE computer ADD CONSTRAINT FK_A298A7A63DD7B7A7 FOREIGN KEY (donor_id) REFERENCES society (id)');
        $this->addSql('ALTER TABLE member_ship ADD CONSTRAINT FK_6B8C7787597D3FE FOREIGN KEY (member_id) REFERENCES contact (id)');
        $this->addSql('ALTER TABLE member_ship ADD CONSTRAINT FK_6B8C778A426D518 FOREIGN KEY (computer_id) REFERENCES computer (id)');
        $this->addSql('ALTER TABLE society ADD CONSTRAINT FK_D6461F28486F9AC FOREIGN KEY (adress_id) REFERENCES adress (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE member_ship DROP FOREIGN KEY FK_6B8C778A426D518');
        $this->addSql('ALTER TABLE computer DROP FOREIGN KEY FK_A298A7A63DD7B7A7');
        $this->addSql('DROP TABLE computer');
        $this->addSql('DROP TABLE member_ship');
        $this->addSql('DROP TABLE society');
    }
}
