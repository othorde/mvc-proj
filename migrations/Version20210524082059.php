<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210524082059 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE yatzy (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, ettor INTEGER DEFAULT NULL, tvåor INTEGER DEFAULT NULL, treor INTEGER DEFAULT NULL, fyror INTEGER DEFAULT NULL, femmor INTEGER DEFAULT NULL, sexor INTEGER DEFAULT NULL, summa INTEGER DEFAULT NULL, bonus INTEGER DEFAULT NULL, par INTEGER DEFAULT NULL, parpar INTEGER DEFAULT NULL, tretal INTEGER DEFAULT NULL, fyrtal INTEGER DEFAULT NULL, straight INTEGER DEFAULT NULL, sstraight INTEGER DEFAULT NULL, kak INTEGER DEFAULT NULL, chans INTEGER DEFAULT NULL, yatzy INTEGER DEFAULT NULL, totalt INTEGER DEFAULT NULL)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE yatzy');
    }
}
