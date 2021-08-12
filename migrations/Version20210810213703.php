<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210810213703 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE check_in (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, construction_site_id INT NOT NULL, date_of_check_in DATETIME NOT NULL, duration INT NOT NULL, created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_90466CF9A76ED395 (user_id), INDEX IDX_90466CF94994A532 (construction_site_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE check_in ADD CONSTRAINT FK_90466CF9A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE check_in ADD CONSTRAINT FK_90466CF94994A532 FOREIGN KEY (construction_site_id) REFERENCES construction_site (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE check_in');
    }
}
