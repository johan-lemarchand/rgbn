<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201104233202 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image_after DROP FOREIGN KEY FK_9E01CAE8A6CEC042');
        $this->addSql('ALTER TABLE image_after ADD CONSTRAINT FK_9E01CAE8A6CEC042 FOREIGN KEY (img_after_id) REFERENCES projects (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE image_before DROP FOREIGN KEY FK_77260366ECAFCEBD');
        $this->addSql('ALTER TABLE image_before ADD CONSTRAINT FK_77260366ECAFCEBD FOREIGN KEY (img_before_id) REFERENCES projects (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_5C93B3A4A6CEC042');
        $this->addSql('ALTER TABLE projects DROP FOREIGN KEY FK_5C93B3A4ECAFCEBD');
        $this->addSql('DROP INDEX UNIQ_5C93B3A4A6CEC042 ON projects');
        $this->addSql('DROP INDEX UNIQ_5C93B3A4ECAFCEBD ON projects');
        $this->addSql('ALTER TABLE projects DROP img_after_id, DROP img_before_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE image_after DROP FOREIGN KEY FK_9E01CAE8A6CEC042');
        $this->addSql('ALTER TABLE image_after ADD CONSTRAINT FK_9E01CAE8A6CEC042 FOREIGN KEY (img_after_id) REFERENCES projects (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE image_before DROP FOREIGN KEY FK_77260366ECAFCEBD');
        $this->addSql('ALTER TABLE image_before ADD CONSTRAINT FK_77260366ECAFCEBD FOREIGN KEY (img_before_id) REFERENCES projects (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE projects ADD img_after_id INT DEFAULT NULL, ADD img_before_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A4A6CEC042 FOREIGN KEY (img_after_id) REFERENCES image (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE projects ADD CONSTRAINT FK_5C93B3A4ECAFCEBD FOREIGN KEY (img_before_id) REFERENCES image (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5C93B3A4A6CEC042 ON projects (img_after_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_5C93B3A4ECAFCEBD ON projects (img_before_id)');
    }
}
