<?php

namespace Bread\ContentBundle\DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180227045656 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        $this->addSql("INSERT INTO menu (title, public, path, sortable_rank) VALUES ('Главная', true, 'homepage', 0), ('Продукция', true, 'product', 1), ('Прайс-лист', true, 'price-list', 2), ('Декларации', true, 'declaration', 3), ('Новости', true, 'news', 4), ('О компании', true, 'about', 5)");
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        $this->addSql("DELETE FROM menu");
    }
}
