<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240109145501 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Table textentry initial data';
    }

    public function up(Schema $schema): void
    {
        $this->addSql(file_get_contents(__DIR__ . '/textentry.sql'));
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DELETE FROM textentry');
    }
}
