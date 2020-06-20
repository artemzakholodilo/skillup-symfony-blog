<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200613133640 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        if (!$schema->hasTable('tags')) {

            $table = $schema->createTable('tags');
            $table->addColumn('id', Types::INTEGER, [
                'length' => 10,
                'autoincrement' => true,
                'pk' => true
            ]);
            $table->addColumn('name', Types::STRING, [
                'notnull' => true
            ]);
            $table->setPrimaryKey(['id']);
        }
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('tags');
    }
}
