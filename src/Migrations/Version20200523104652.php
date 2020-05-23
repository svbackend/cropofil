<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20200523104652 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE photo (id SERIAL NOT NULL, gallery_id UUID DEFAULT NULL, client_filename VARCHAR(255) NOT NULL, filename VARCHAR(255) NOT NULL, exif JSON NOT NULL, w INT NOT NULL, h INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_14B784184E7AF8F ON photo (gallery_id)');
        $this->addSql('COMMENT ON COLUMN photo.gallery_id IS \'(DC2Type:uuid)\'');
        $this->addSql('CREATE TABLE gallery (id UUID NOT NULL, shortcut VARCHAR(50) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_472B783A2EF83F9C ON gallery (shortcut)');
        $this->addSql('COMMENT ON COLUMN gallery.id IS \'(DC2Type:uuid)\'');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784184E7AF8F FOREIGN KEY (gallery_id) REFERENCES gallery (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('ALTER TABLE photo DROP CONSTRAINT FK_14B784184E7AF8F');
        $this->addSql('DROP TABLE photo');
        $this->addSql('DROP TABLE gallery');
    }
}
