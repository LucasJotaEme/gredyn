<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220213073327 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql("INSERT INTO `ranking`(`name`, `number_from`, `number_to`) VALUES 
        ('Trainee', 0, 25),
        ('Semi junior', 26, 50),
        ('Junior', 26, 50),
        ('Semi senior', 51, 25),
        ('Senior', 51, 25);");

    }

    public function down(Schema $schema): void
    {
        $this->addSql("DELETE FROM 'ranking'");
    }
}
