<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191011090404 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE camp (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, author VARCHAR(255) NOT NULL, date DATE NOT NULL, image VARCHAR(255) NOT NULL, in_preview TINYINT(1) NOT NULL, likes INT NOT NULL, created_at DATETIME DEFAULT NULL, updated_at DATETIME DEFAULT NULL, sort INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE camp_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, quote VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_17255E232C2AC5D3 (translatable_id), UNIQUE INDEX camp_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE review (id INT AUTO_INCREMENT NOT NULL, camp_id_id INT NOT NULL, user_name VARCHAR(255) NOT NULL, message LONGTEXT NOT NULL, created_time DATETIME NOT NULL, INDEX IDX_794381C6717AF4CB (camp_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE camp_translation ADD CONSTRAINT FK_17255E232C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES camp (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE review ADD CONSTRAINT FK_794381C6717AF4CB FOREIGN KEY (camp_id_id) REFERENCES camp (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE camp_translation DROP FOREIGN KEY FK_17255E232C2AC5D3');
        $this->addSql('ALTER TABLE review DROP FOREIGN KEY FK_794381C6717AF4CB');
        $this->addSql('DROP TABLE camp');
        $this->addSql('DROP TABLE camp_translation');
        $this->addSql('DROP TABLE review');
    }
}
