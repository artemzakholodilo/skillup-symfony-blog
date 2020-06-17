<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200613134430 extends AbstractMigration
{
    const DEFAULT_RATING = 4.0;

    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        $this->addSql("INSERT INTO categories(name) VALUES('default')");
        $column = $schema->getTable('categories')->getColumn('rating');
        $column->setDefault(self::DEFAULT_RATING);
    }

    public function down(Schema $schema) : void
    {
        $this->addSql("DELETE FROM categories where name = 'default')");
        $column = $schema->getTable('categories')->getColumn('rating');
        $column->setDefault(5);
    }
}
