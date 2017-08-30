<?php

namespace AppBundle\DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170822141857 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE news (id SERIAL NOT NULL, title VARCHAR(255) NOT NULL, description TEXT DEFAULT NULL, public BOOLEAN DEFAULT \'true\' NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, image_crop VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE news_images (new_id INT NOT NULL, image_id INT NOT NULL, PRIMARY KEY(new_id, image_id))');
        $this->addSql('CREATE INDEX IDX_6CB67D1EBD06B3B3 ON news_images (new_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_6CB67D1E3DA5256D ON news_images (image_id)');
        $this->addSql('ALTER TABLE news_images ADD CONSTRAINT FK_6CB67D1EBD06B3B3 FOREIGN KEY (new_id) REFERENCES news (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE news_images ADD CONSTRAINT FK_6CB67D1E3DA5256D FOREIGN KEY (image_id) REFERENCES images (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE news_images DROP CONSTRAINT FK_6CB67D1EBD06B3B3');
        $this->addSql('DROP TABLE news');
        $this->addSql('DROP TABLE news_images');
    }
}
