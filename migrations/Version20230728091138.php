<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
<<<<<<<< HEAD:migrations/Version20230522200338.php
final class Version20230522200338 extends AbstractMigration
========
final class Version20230728091138 extends AbstractMigration
>>>>>>>> 1a15b9c39befc6b3acd191ed526c9da49bb6664b:migrations/Version20230728091138.php
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
<<<<<<<< HEAD:migrations/Version20230522200338.php
        $this->addSql('CREATE TABLE services (id INT AUTO_INCREMENT NOT NULL, label VARCHAR(255) NOT NULL, pos INT NOT NULL, title VARCHAR(255) NOT NULL, content LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
========
        $this->addSql('ALTER TABLE menus_list ADD menu_pos JSON NOT NULL');
>>>>>>>> 1a15b9c39befc6b3acd191ed526c9da49bb6664b:migrations/Version20230728091138.php
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
<<<<<<<< HEAD:migrations/Version20230522200338.php
        $this->addSql('DROP TABLE services');
========
        $this->addSql('ALTER TABLE menus_list DROP menu_pos');
>>>>>>>> 1a15b9c39befc6b3acd191ed526c9da49bb6664b:migrations/Version20230728091138.php
    }
}
