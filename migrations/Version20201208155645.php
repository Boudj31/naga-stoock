<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201208155645 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE computer ADD member_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE computer ADD CONSTRAINT FK_A298A7A67597D3FE FOREIGN KEY (member_id) REFERENCES member_ship (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A298A7A67597D3FE ON computer (member_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE computer DROP FOREIGN KEY FK_A298A7A67597D3FE');
        $this->addSql('DROP INDEX UNIQ_A298A7A67597D3FE ON computer');
        $this->addSql('ALTER TABLE computer DROP member_id');
    }
}
