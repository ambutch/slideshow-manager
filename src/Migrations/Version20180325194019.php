<?php declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180325194019 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('CREATE TABLE directory (id CHAR(36) NOT NULL --(DC2Type:uuid)
        , parent_id CHAR(36) DEFAULT NULL --(DC2Type:uuid)
        , root_id CHAR(36) DEFAULT NULL --(DC2Type:uuid)
        , name VARCHAR(255) NOT NULL, lft INTEGER NOT NULL, rgt INTEGER NOT NULL, lvl INTEGER NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_467844DA727ACA70 ON directory (parent_id)');
        $this->addSql('CREATE INDEX IDX_467844DA79066886 ON directory (root_id)');
        $this->addSql('CREATE TABLE photo (id CHAR(36) NOT NULL --(DC2Type:uuid)
        , parent_id CHAR(36) NOT NULL --(DC2Type:uuid)
        , base_name VARCHAR(255) NOT NULL, full_path VARCHAR(1024) NOT NULL, published BOOLEAN DEFAULT \'0\' NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_14B78418727ACA70 ON photo (parent_id)');
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'sqlite', 'Migration can only be executed safely on \'sqlite\'.');

        $this->addSql('DROP TABLE directory');
        $this->addSql('DROP TABLE photo');
    }
}
