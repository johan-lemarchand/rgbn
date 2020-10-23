<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201022135252 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE category (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, category_id INT DEFAULT NULL, projects_id INT DEFAULT NULL, partner_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_C53D045F12469DE2 (category_id), INDEX IDX_C53D045F1EDE0F55 (projects_id), UNIQUE INDEX UNIQ_C53D045F9393F8FE (partner_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE partner (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, content LONGTEXT NOT NULL, phone VARCHAR(255) NOT NULL, link VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE projects (id INT AUTO_INCREMENT NOT NULL, category_id INT NOT NULL, img_after_id INT DEFAULT NULL, img_before_id INT DEFAULT NULL, title VARCHAR(255) DEFAULT NULL, content LONGTEXT NOT NULL, created_at DATETIME NOT NULL, INDEX IDX_5C93B3A412469DE2 (category_id), UNIQUE INDEX UNIQ_5C93B3A4A6CEC042 (img_after_id), UNIQUE INDEX UNIQ_5C93B3A4ECAFCEBD (img_before_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, name VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F1EDE0F55 FOREIGN KEY (projects_id) REFERENCES projects (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F9393F8FE FOREIGN KEY (partner_id) REFERENCES partner (id)');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A412469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A4A6CEC042 FOREIGN KEY (img_after_id) REFERENCES image (id)');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A4ECAFCEBD FOREIGN KEY (img_before_id) REFERENCES image (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F12469DE2');
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_5C93B3A412469DE2');
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_5C93B3A4A6CEC042');
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_5C93B3A4ECAFCEBD');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F9393F8FE');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F1EDE0F55');
        $this->addSql('DROP TABLE category');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE partner');
        $this->addSql('DROP TABLE projects');
        $this->addSql('DROP TABLE user');
    }
}
