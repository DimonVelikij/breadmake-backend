<?php

namespace AppBundle\DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170814162420 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE images (id SERIAL NOT NULL, file_name VARCHAR(255) NOT NULL, crop_file_name VARCHAR(255) NOT NULL, path VARCHAR(255) NOT NULL, crop_path VARCHAR(255) NOT NULL, asset_path VARCHAR(255) NOT NULL, asset_crop_path VARCHAR(255) NOT NULL, extension VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('ALTER TABLE products ADD image_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE products DROP image');
        $this->addSql('ALTER TABLE products ADD CONSTRAINT FK_B3BA5A5A3DA5256D FOREIGN KEY (image_id) REFERENCES images (id) ON DELETE SET NULL NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_B3BA5A5A3DA5256D ON products (image_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE products DROP CONSTRAINT FK_B3BA5A5A3DA5256D');
        $this->addSql('DROP TABLE images');
        $this->addSql('DROP INDEX UNIQ_B3BA5A5A3DA5256D');
        $this->addSql('ALTER TABLE products ADD image VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE products DROP image_id');
    }
}
