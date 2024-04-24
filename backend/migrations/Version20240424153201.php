<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240424153201 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE albums_tunes (album_id INT NOT NULL, tune_id INT NOT NULL, PRIMARY KEY(album_id, tune_id))');
        $this->addSql('CREATE INDEX IDX_55003A311137ABCF ON albums_tunes (album_id)');
        $this->addSql('CREATE INDEX IDX_55003A316D5E650B ON albums_tunes (tune_id)');
        $this->addSql('ALTER TABLE albums_tunes ADD CONSTRAINT FK_55003A311137ABCF FOREIGN KEY (album_id) REFERENCES album_entity (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE albums_tunes ADD CONSTRAINT FK_55003A316D5E650B FOREIGN KEY (tune_id) REFERENCES tune_entity (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE albums_tunes DROP CONSTRAINT FK_55003A311137ABCF');
        $this->addSql('ALTER TABLE albums_tunes DROP CONSTRAINT FK_55003A316D5E650B');
        $this->addSql('DROP TABLE albums_tunes');
    }
}
