<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180903012352 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_fiction_chapter (user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', fiction_chapter_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', INDEX IDX_640AA447A76ED395 (user_id), INDEX IDX_640AA447956E2819 (fiction_chapter_id), PRIMARY KEY(user_id, fiction_chapter_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_fiction_chapter ADD CONSTRAINT FK_640AA447A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_fiction_chapter ADD CONSTRAINT FK_640AA447956E2819 FOREIGN KEY (fiction_chapter_id) REFERENCES fiction_chapter (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE user_fiction');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE user_fiction (fiction_id CHAR(36) NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:uuid)\', user_id CHAR(36) NOT NULL COLLATE utf8mb4_unicode_ci COMMENT \'(DC2Type:uuid)\', INDEX IDX_375A17F7A76ED395 (user_id), INDEX IDX_375A17F7FF905AC2 (fiction_id), PRIMARY KEY(user_id, fiction_id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user_fiction ADD CONSTRAINT FK_375A17F7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('ALTER TABLE user_fiction ADD CONSTRAINT FK_375A17F7FF905AC2 FOREIGN KEY (fiction_id) REFERENCES fiction (id) ON UPDATE NO ACTION ON DELETE CASCADE');
        $this->addSql('DROP TABLE user_fiction_chapter');
    }
}
