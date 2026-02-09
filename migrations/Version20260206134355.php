<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260206134355 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tbl_connection ADD image_a_to_b VARCHAR(255) NOT NULL, ADD image_b_to_a VARCHAR(255) NOT NULL, CHANGE instruction_b_to_a instruction_b_to_a LONGTEXT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE tbl_connection DROP image_a_to_b, DROP image_b_to_a, CHANGE instruction_b_to_a instruction_b_to_a LONGTEXT DEFAULT NULL');
    }
}
