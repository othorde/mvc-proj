<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210524100550 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__yatzy AS SELECT id, name, ettor, tvåor, treor, fyror, femmor, sexor, summa, bonus, par, parpar, tretal, fyrtal, straight, sstraight, kak, chans, yatzy, totalt FROM yatzy');
        $this->addSql('DROP TABLE yatzy');
        $this->addSql('CREATE TABLE yatzy (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL COLLATE BINARY, ettor INTEGER DEFAULT NULL, treor INTEGER DEFAULT NULL, fyror INTEGER DEFAULT NULL, femmor INTEGER DEFAULT NULL, sexor INTEGER DEFAULT NULL, summa INTEGER DEFAULT NULL, bonus INTEGER DEFAULT NULL, par INTEGER DEFAULT NULL, parpar INTEGER DEFAULT NULL, tretal INTEGER DEFAULT NULL, fyrtal INTEGER DEFAULT NULL, straight INTEGER DEFAULT NULL, sstraight INTEGER DEFAULT NULL, kak INTEGER DEFAULT NULL, chans INTEGER DEFAULT NULL, yatzy INTEGER DEFAULT NULL, totalt INTEGER DEFAULT NULL, tvaor INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO yatzy (id, name, ettor, tvaor, treor, fyror, femmor, sexor, summa, bonus, par, parpar, tretal, fyrtal, straight, sstraight, kak, chans, yatzy, totalt) SELECT id, name, ettor, tvåor, treor, fyror, femmor, sexor, summa, bonus, par, parpar, tretal, fyrtal, straight, sstraight, kak, chans, yatzy, totalt FROM __temp__yatzy');
        $this->addSql('DROP TABLE __temp__yatzy');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__yatzy AS SELECT id, name, ettor, tvaor, treor, fyror, femmor, sexor, summa, bonus, par, parpar, tretal, fyrtal, straight, sstraight, kak, chans, yatzy, totalt FROM yatzy');
        $this->addSql('DROP TABLE yatzy');
        $this->addSql('CREATE TABLE yatzy (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, ettor INTEGER DEFAULT NULL, treor INTEGER DEFAULT NULL, fyror INTEGER DEFAULT NULL, femmor INTEGER DEFAULT NULL, sexor INTEGER DEFAULT NULL, summa INTEGER DEFAULT NULL, bonus INTEGER DEFAULT NULL, par INTEGER DEFAULT NULL, parpar INTEGER DEFAULT NULL, tretal INTEGER DEFAULT NULL, fyrtal INTEGER DEFAULT NULL, straight INTEGER DEFAULT NULL, sstraight INTEGER DEFAULT NULL, kak INTEGER DEFAULT NULL, chans INTEGER DEFAULT NULL, yatzy INTEGER DEFAULT NULL, totalt INTEGER DEFAULT NULL, tvåor INTEGER DEFAULT NULL)');
        $this->addSql('INSERT INTO yatzy (id, name, ettor, tvåor, treor, fyror, femmor, sexor, summa, bonus, par, parpar, tretal, fyrtal, straight, sstraight, kak, chans, yatzy, totalt) SELECT id, name, ettor, tvaor, treor, fyror, femmor, sexor, summa, bonus, par, parpar, tretal, fyrtal, straight, sstraight, kak, chans, yatzy, totalt FROM __temp__yatzy');
        $this->addSql('DROP TABLE __temp__yatzy');
    }
}
