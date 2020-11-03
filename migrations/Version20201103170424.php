<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201103170424 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F1EDE0F55');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F1EDE0F55 FOREIGN KEY (projects_id) REFERENCES projects (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045F1EDE0F55');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045F1EDE0F55 FOREIGN KEY (projects_id) REFERENCES projects (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
