<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221029035418 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE directory (id BINARY(16) NOT NULL, customer_id BINARY(16) NOT NULL, contact_id BINARY(16) NOT NULL, INDEX IDX_467844DA9395C3F3 (customer_id), INDEX IDX_467844DAE7A1254A (contact_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE directory ADD CONSTRAINT FK_467844DA9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE directory ADD CONSTRAINT FK_467844DAE7A1254A FOREIGN KEY (contact_id) REFERENCES contact (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE directory DROP FOREIGN KEY FK_467844DA9395C3F3');
        $this->addSql('ALTER TABLE directory DROP FOREIGN KEY FK_467844DAE7A1254A');
        $this->addSql('DROP TABLE directory');
    }
}
