<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20240109145500 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Initial AUTO_INCREMENT values to be compatible with old database';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE survey AUTO_INCREMENT=1000');
        $this->addSql('ALTER TABLE group_text_mapping AUTO_INCREMENT=10000');
        $this->addSql('ALTER TABLE variant AUTO_INCREMENT=500');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE survey AUTO_INCREMENT=1');
        $this->addSql('ALTER TABLE group_text_mapping AUTO_INCREMENT=1');
        $this->addSql('ALTER TABLE variant AUTO_INCREMENT=1');
    }
}
