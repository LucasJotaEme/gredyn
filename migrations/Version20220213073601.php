<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220213073601 extends AbstractMigration
{
    // IMPORTANT: You must execute php bin/console doctrine:schema:update --force
    // It's probably that not execute if the database isn't update.
    public function getDescription(): string
    {
        return 'Star and your points';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('
            INSERT INTO `star`(`star`, `point`) VALUES (1,1), (2,2), (3,3), (4, 4), (5, 5);
        ');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('
            DELETE FROM `star`;
        ');

    }
}
