<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180829042347 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE fiction (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', created_at DATETIME NOT NULL, title VARCHAR(191) NOT NULL, slug VARCHAR(191) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fiction_chapter (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', fiction_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', title VARCHAR(191) NOT NULL, slug VARCHAR(191) NOT NULL, body LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, position INT NOT NULL, INDEX IDX_76D6C8C8FF905AC2 (fiction_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fiction_chapter ADD CONSTRAINT FK_76D6C8C8FF905AC2 FOREIGN KEY (fiction_id) REFERENCES fiction (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fiction_chapter DROP FOREIGN KEY FK_76D6C8C8FF905AC2');
        $this->addSql('DROP TABLE fiction');
        $this->addSql('DROP TABLE fiction_chapter');
    }
}
