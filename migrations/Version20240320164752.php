<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240320164752 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE author (id INT AUTO_INCREMENT NOT NULL, firstname VARCHAR(255) DEFAULT NULL, lastname VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE book (id INT AUTO_INCREMENT NOT NULL, author_id INT NOT NULL, name VARCHAR(255) NOT NULL, release_year DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', cover VARCHAR(2083) DEFAULT NULL, INDEX IDX_CBE5A331F675F31B (author_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE library (id INT AUTO_INCREMENT NOT NULL, rating INT DEFAULT NULL, reading_date DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', opinion LONGTEXT DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE library_book (library_id INT NOT NULL, book_id INT NOT NULL, INDEX IDX_6D2A695CFE2541D7 (library_id), INDEX IDX_6D2A695C16A2B381 (book_id), PRIMARY KEY(library_id, book_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, library_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_8D93D649FE2541D7 (library_id), UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE book ADD CONSTRAINT FK_CBE5A331F675F31B FOREIGN KEY (author_id) REFERENCES author (id)');
        $this->addSql('ALTER TABLE library_book ADD CONSTRAINT FK_6D2A695CFE2541D7 FOREIGN KEY (library_id) REFERENCES library (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE library_book ADD CONSTRAINT FK_6D2A695C16A2B381 FOREIGN KEY (book_id) REFERENCES book (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649FE2541D7 FOREIGN KEY (library_id) REFERENCES library (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book DROP FOREIGN KEY FK_CBE5A331F675F31B');
        $this->addSql('ALTER TABLE library_book DROP FOREIGN KEY FK_6D2A695CFE2541D7');
        $this->addSql('ALTER TABLE library_book DROP FOREIGN KEY FK_6D2A695C16A2B381');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649FE2541D7');
        $this->addSql('DROP TABLE author');
        $this->addSql('DROP TABLE book');
        $this->addSql('DROP TABLE library');
        $this->addSql('DROP TABLE library_book');
        $this->addSql('DROP TABLE user');
    }
}
