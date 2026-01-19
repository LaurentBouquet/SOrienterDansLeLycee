<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260119143707 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE tbl_connection (id INT AUTO_INCREMENT NOT NULL, weight INT NOT NULL, pmr TINYINT NOT NULL, instruction_a_to_b LONGTEXT NOT NULL, instruction_b_to_a LONGTEXT NOT NULL, location_a_id INT NOT NULL, location_b_id INT NOT NULL, INDEX IDX_40B439F7BBDAE618 (location_a_id), INDEX IDX_40B439F7A96F49F6 (location_b_id), PRIMARY KEY (id)) DEFAULT CHARACTER SET utf8mb4');
        $this->addSql('ALTER TABLE tbl_connection ADD CONSTRAINT FK_40B439F7BBDAE618 FOREIGN KEY (location_a_id) REFERENCES tbl_location (id)');
        $this->addSql('ALTER TABLE tbl_connection ADD CONSTRAINT FK_40B439F7A96F49F6 FOREIGN KEY (location_b_id) REFERENCES tbl_location (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tbl_connection DROP FOREIGN KEY FK_40B439F7BBDAE618');
        $this->addSql('ALTER TABLE tbl_connection DROP FOREIGN KEY FK_40B439F7A96F49F6');
        $this->addSql('DROP TABLE tbl_connection');
    }
}
