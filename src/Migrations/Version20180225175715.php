<?php declare(strict_types = 1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180225175715 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE app_tickets (id INT AUTO_INCREMENT NOT NULL, assignee INT DEFAULT NULL, requester INT DEFAULT NULL, created_on DATETIME NOT NULL, updated_on DATETIME DEFAULT NULL, Status VARCHAR(255) NOT NULL, INDEX IDX_B91B1DB97C9DFC0C (assignee), INDEX IDX_B91B1DB96C86AEFE (requester), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE app_users (id INT AUTO_INCREMENT NOT NULL, password VARCHAR(64) NOT NULL, email VARCHAR(60) NOT NULL, first_name VARCHAR(60) NOT NULL, last_name VARCHAR(60) NOT NULL, is_active TINYINT(1) NOT NULL, is_agent TINYINT(1) NOT NULL, is_admin TINYINT(1) NOT NULL, UNIQUE INDEX UNIQ_C2502824E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE app_tickets ADD CONSTRAINT FK_B91B1DB97C9DFC0C FOREIGN KEY (assignee) REFERENCES app_users (id)');
        $this->addSql('ALTER TABLE app_tickets ADD CONSTRAINT FK_B91B1DB96C86AEFE FOREIGN KEY (requester) REFERENCES app_users (id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE app_tickets DROP FOREIGN KEY FK_B91B1DB97C9DFC0C');
        $this->addSql('ALTER TABLE app_tickets DROP FOREIGN KEY FK_B91B1DB96C86AEFE');
        $this->addSql('DROP TABLE app_tickets');
        $this->addSql('DROP TABLE app_users');
    }
}
