<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20180903011538 extends AbstractMigration
{
    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE user CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE fiction ADD updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE comment CHANGE updated_at updated_at DATETIME NOT NULL');
        $this->addSql('ALTER TABLE fiction_chapter ADD updated_at DATETIME NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE comment CHANGE updated_at updated_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE fiction DROP updated_at');
        $this->addSql('ALTER TABLE fiction_chapter DROP updated_at');
        $this->addSql('ALTER TABLE user CHANGE updated_at updated_at DATETIME DEFAULT NULL');
    }
}
