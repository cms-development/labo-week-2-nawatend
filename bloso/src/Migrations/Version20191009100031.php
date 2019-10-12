<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20191009100031 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE camp_translation (id INT AUTO_INCREMENT NOT NULL, translatable_id INT DEFAULT NULL, quote VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, locale VARCHAR(255) NOT NULL, INDEX IDX_17255E232C2AC5D3 (translatable_id), UNIQUE INDEX camp_translation_unique_translation (translatable_id, locale), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE camp_translation ADD CONSTRAINT FK_17255E232C2AC5D3 FOREIGN KEY (translatable_id) REFERENCES camp (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE camp ADD created_at DATETIME DEFAULT NULL, ADD updated_at DATETIME DEFAULT NULL, ADD sort INT NOT NULL, DROP quote, DROP description');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE camp_translation');
        $this->addSql('ALTER TABLE camp ADD quote VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci, ADD description LONGTEXT NOT NULL COLLATE utf8mb4_unicode_ci, DROP created_at, DROP updated_at, DROP sort');
    }
}
