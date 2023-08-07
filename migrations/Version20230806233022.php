<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230806233022 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE pages_list ADD page_content JSON DEFAULT NULL, DROP page_meta_title_en, DROP page_meta_desc_en, CHANGE page_name page_name JSON NOT NULL, CHANGE page_meta_title page_meta_title JSON DEFAULT NULL, CHANGE page_meta_desc page_meta_desc JSON NOT NULL');
        $this->addSql('ALTER TABLE posts_list ADD author_id INT NOT NULL, ADD post_content JSON NOT NULL, ADD online TINYINT(1) DEFAULT NULL, DROP post_name_en, DROP post_id, DROP post_meta_title_en, DROP post_meta_desc_en, DROP status, CHANGE post_name post_name JSON NOT NULL, CHANGE post_meta_title post_meta_title JSON NOT NULL, CHANGE post_meta_desc post_meta_desc JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE posts_list ADD CONSTRAINT FK_FE98C1A1F675F31B FOREIGN KEY (author_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_FE98C1A1F675F31B ON posts_list (author_id)');
        $this->addSql('ALTER TABLE messenger_messages CHANGE created_at created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE available_at available_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', CHANGE delivered_at delivered_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE messenger_messages CHANGE created_at created_at DATETIME NOT NULL, CHANGE available_at available_at DATETIME NOT NULL, CHANGE delivered_at delivered_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE pages_list ADD page_meta_title_en VARCHAR(255) DEFAULT NULL, ADD page_meta_desc_en VARCHAR(255) DEFAULT NULL, DROP page_content, CHANGE page_name page_name VARCHAR(255) NOT NULL, CHANGE page_meta_title page_meta_title VARCHAR(255) DEFAULT NULL, CHANGE page_meta_desc page_meta_desc VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE posts_list DROP FOREIGN KEY FK_FE98C1A1F675F31B');
        $this->addSql('DROP INDEX IDX_FE98C1A1F675F31B ON posts_list');
        $this->addSql('ALTER TABLE posts_list ADD post_name_en VARCHAR(255) DEFAULT NULL, ADD post_id VARCHAR(255) NOT NULL, ADD post_meta_title_en VARCHAR(255) DEFAULT NULL, ADD post_meta_desc_en VARCHAR(255) DEFAULT NULL, ADD status TINYINT(1) NOT NULL, DROP author_id, DROP post_content, DROP online, CHANGE post_name post_name VARCHAR(255) NOT NULL, CHANGE post_meta_title post_meta_title VARCHAR(255) DEFAULT NULL, CHANGE post_meta_desc post_meta_desc VARCHAR(255) DEFAULT NULL');
    }
}
