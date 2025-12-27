<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20251227152140 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE task (id UUID NOT NULL, name VARCHAR(255) NOT NULL, state VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, expected_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, deleted_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, created_by_id UUID DEFAULT NULL, updated_by_id UUID DEFAULT NULL, deleted_by_id UUID DEFAULT NULL, PRIMARY KEY (id))');
        $this->addSql('CREATE INDEX IDX_527EDB25B03A8386 ON task (created_by_id)');
        $this->addSql('CREATE INDEX IDX_527EDB25896DBBDE ON task (updated_by_id)');
        $this->addSql('CREATE INDEX IDX_527EDB25C76F1F52 ON task (deleted_by_id)');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25B03A8386 FOREIGN KEY (created_by_id) REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25896DBBDE FOREIGN KEY (updated_by_id) REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE');
        $this->addSql('ALTER TABLE task ADD CONSTRAINT FK_527EDB25C76F1F52 FOREIGN KEY (deleted_by_id) REFERENCES "user" (id) ON DELETE SET NULL NOT DEFERRABLE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE task DROP CONSTRAINT FK_527EDB25B03A8386');
        $this->addSql('ALTER TABLE task DROP CONSTRAINT FK_527EDB25896DBBDE');
        $this->addSql('ALTER TABLE task DROP CONSTRAINT FK_527EDB25C76F1F52');
        $this->addSql('DROP TABLE task');
    }
}
