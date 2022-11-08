<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20221108030711 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Campos adicionales tabla project';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project ADD `key` VARCHAR(50) NOT NULL, ADD start_date DATE NOT NULL, ADD logo VARCHAR(250) NOT NULL, ADD color VARCHAR(50) NOT NULL, ADD description LONGTEXT DEFAULT NULL, ADD observation LONGTEXT DEFAULT NULL, ADD config_data JSON NOT NULL, ADD suspended TINYINT(1) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE project DROP `key`, DROP start_date, DROP logo, DROP color, DROP description, DROP observation, DROP config_data, DROP suspended');
    }
}
