<?php

namespace AppBundle\DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170610084817 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE TABLE products_orders (product_id INT NOT NULL, order_id INT NOT NULL, count INT NOT NULL, PRIMARY KEY(product_id, order_id))');
        $this->addSql('CREATE INDEX IDX_631C76C44584665A ON products_orders (product_id)');
        $this->addSql('CREATE INDEX IDX_631C76C48D9F6D38 ON products_orders (order_id)');
        $this->addSql('ALTER TABLE products_orders ADD CONSTRAINT FK_631C76C44584665A FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE products_orders ADD CONSTRAINT FK_631C76C48D9F6D38 FOREIGN KEY (order_id) REFERENCES orders (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE clients ALTER login DROP NOT NULL');
        $this->addSql('ALTER TABLE clients ALTER password DROP NOT NULL');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'postgresql', 'Migration can only be executed safely on \'postgresql\'.');

        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE products_orders');
        $this->addSql('ALTER TABLE clients ALTER login SET NOT NULL');
        $this->addSql('ALTER TABLE clients ALTER password SET NOT NULL');
    }
}
