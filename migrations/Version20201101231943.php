<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201101231943 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FA6CEC042');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FECAFCEBD');
        $this->addSql('DROP INDEX UNIQ_C53D045FA6CEC042 ON image');
        $this->addSql('DROP INDEX UNIQ_C53D045FECAFCEBD ON image');
        $this->addSql('ALTER TABLE image DROP img_after_id, DROP img_before_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image ADD img_after_id INT DEFAULT NULL, ADD img_before_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FA6CEC042 FOREIGN KEY (img_after_id) REFERENCES projects (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FECAFCEBD FOREIGN KEY (img_before_id) REFERENCES projects (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C53D045FA6CEC042 ON image (img_after_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C53D045FECAFCEBD ON image (img_before_id)');
    }
}
