<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180912075559 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE fiction_category (id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', title VARCHAR(191) NOT NULL, slug VARCHAR(191) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE fiction_category_fiction (fiction_category_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', fiction_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_DF62449735862D27 (fiction_category_id), INDEX IDX_DF624497FF905AC2 (fiction_id), PRIMARY KEY(fiction_category_id, fiction_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fiction_category_fiction ADD CONSTRAINT FK_DF62449735862D27 FOREIGN KEY (fiction_category_id) REFERENCES fiction_category (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE fiction_category_fiction ADD CONSTRAINT FK_DF624497FF905AC2 FOREIGN KEY (fiction_id) REFERENCES fiction (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE fiction_category_fiction DROP FOREIGN KEY FK_DF62449735862D27');
        $this->addSql('DROP TABLE fiction_category');
        $this->addSql('DROP TABLE fiction_category_fiction');
    }
}
