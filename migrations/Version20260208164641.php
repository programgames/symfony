<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260208164641 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Add columns only if they don't exist
        $this->addSql('ALTER TABLE game_sessions ADD COLUMN IF NOT EXISTS current_hint JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE game_sessions ADD COLUMN IF NOT EXISTS shape_hint_used BOOLEAN NOT NULL DEFAULT FALSE');
        $this->addSql('ALTER TABLE game_sessions ADD COLUMN IF NOT EXISTS last_skipped_pokemon_name VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE game_sessions ADD COLUMN IF NOT EXISTS last_skipped_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE players ADD COLUMN IF NOT EXISTS points INT NOT NULL DEFAULT 0');
        $this->addSql('ALTER TABLE players ADD COLUMN IF NOT EXISTS current_streak INT NOT NULL DEFAULT 0');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game_sessions DROP current_hint');
        $this->addSql('ALTER TABLE game_sessions DROP shape_hint_used');
        $this->addSql('ALTER TABLE game_sessions DROP last_skipped_pokemon_name');
        $this->addSql('ALTER TABLE game_sessions DROP last_skipped_at');
        $this->addSql('ALTER TABLE players DROP points');
        $this->addSql('ALTER TABLE players DROP current_streak');
        $this->addSql('ALTER INDEX idx_264e43a68fe32b32 RENAME TO idx_264e43a67e5a734c');
    }
}
