<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241007182237 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE movies (id INT AUTO_INCREMENT NOT NULL, title VARCHAR(255) NOT NULL, overview TINYTEXT NOT NULL, status VARCHAR(255) NOT NULL, adult TINYINT(1) NOT NULL, image_url VARCHAR(255) NOT NULL, aggregate_rating DOUBLE PRECISION NOT NULL, vote_count INT NOT NULL, release_date DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', runtime INT NOT NULL, genres LONGTEXT NOT NULL COMMENT \'(DC2Type:simple_array)\', movie_id INT NOT NULL, UNIQUE INDEX UNIQ_C61EED308F93B6FC (movie_id), INDEX movie_title_idx (title), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE movies');
    }
}
