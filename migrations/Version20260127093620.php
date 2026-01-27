<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260127093620 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tbl_connection CHANGE instruction_a_to_b instruction_a_to_b LONGTEXT NOT NULL, CHANGE instruction_b_to_a instruction_b_to_a LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE tbl_connection RENAME INDEX location_a_id TO IDX_40B439F7BBDAE618');
        $this->addSql('ALTER TABLE tbl_connection RENAME INDEX location_b_id TO IDX_40B439F7A96F49F6');
        $this->addSql('ALTER TABLE tbl_location ADD image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE tbl_user ADD email VARCHAR(180) NOT NULL, ADD roles JSON NOT NULL, DROP username, DROP role, CHANGE password password VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL ON tbl_user (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tbl_connection CHANGE instruction_a_to_b instruction_a_to_b TEXT DEFAULT NULL, CHANGE instruction_b_to_a instruction_b_to_a TEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE tbl_connection RENAME INDEX idx_40b439f7bbdae618 TO location_a_id');
        $this->addSql('ALTER TABLE tbl_connection RENAME INDEX idx_40b439f7a96f49f6 TO location_b_id');
        $this->addSql('ALTER TABLE tbl_location DROP image');
        $this->addSql('DROP INDEX UNIQ_IDENTIFIER_EMAIL ON tbl_user');
        $this->addSql('ALTER TABLE tbl_user ADD username VARCHAR(50) DEFAULT \'0\' NOT NULL, ADD role VARCHAR(50) DEFAULT \'\' NOT NULL, DROP email, DROP roles, CHANGE password password VARCHAR(50) DEFAULT \'0\' NOT NULL');
    }
}
