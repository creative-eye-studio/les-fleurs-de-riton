<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230523081604 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE services_images (id INT AUTO_INCREMENT NOT NULL, serv_id_id INT NOT NULL, img_name VARCHAR(255) NOT NULL, INDEX IDX_78717C6CCD733292 (serv_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE services_images ADD CONSTRAINT FK_78717C6CCD733292 FOREIGN KEY (serv_id_id) REFERENCES services (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE services_images DROP FOREIGN KEY FK_78717C6CCD733292');
        $this->addSql('DROP TABLE services_images');
    }
}
