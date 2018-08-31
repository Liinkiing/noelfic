<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180831071927 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE fiction_user_rating (fiction_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', user_id CHAR(36) NOT NULL COMMENT \'(DC2Type:uuid)\', rating DOUBLE PRECISION NOT NULL, rated_at DATETIME NOT NULL, INDEX IDX_9A1B8DDAFF905AC2 (fiction_id), INDEX IDX_9A1B8DDAA76ED395 (user_id), PRIMARY KEY(fiction_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE fiction_user_rating ADD CONSTRAINT FK_9A1B8DDAFF905AC2 FOREIGN KEY (fiction_id) REFERENCES fiction (id)');
        $this->addSql('ALTER TABLE fiction_user_rating ADD CONSTRAINT FK_9A1B8DDAA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE fiction_user_rating');
    }
}
