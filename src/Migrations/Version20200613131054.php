<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200613131054 extends AbstractMigration
{
    const DEFAULT_RATING = 5.0;

    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        if (!$schema->hasTable('categories')) {
            $table = $schema->createTable('categories');
            $table->addColumn('id', TypeS::INTEGER, [
                'length' => 10,
                'autoincrement' => true,
                'pk' => true
            ]);
            $table->addColumn('name', Types::STRING, [
                'notnull' => true
            ]);
            $table->addColumn('rating', TYPES::FLOAT, [
                'default' => self::DEFAULT_RATING
            ]);
            $table->setPrimaryKey(['id']);
        }
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('categories');
    }
}
