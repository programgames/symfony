<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260207135435 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add shared hint, skipped pokemon sync, and point system fields for multiplayer quiz';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game_sessions ADD current_hint JSON DEFAULT NULL');
        $this->addSql('ALTER TABLE game_sessions ADD last_skipped_pokemon_name VARCHAR(100) DEFAULT NULL');
        $this->addSql('ALTER TABLE game_sessions ADD last_skipped_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL');
        $this->addSql('ALTER TABLE players ADD points INT NOT NULL DEFAULT 0');
        $this->addSql('ALTER TABLE players ADD current_streak INT NOT NULL DEFAULT 0');
        $this->addSql('ALTER INDEX idx_264e43a67e5a734c RENAME TO IDX_264E43A68FE32B32');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE game_sessions DROP current_hint');
        $this->addSql('ALTER TABLE game_sessions DROP last_skipped_pokemon_name');
        $this->addSql('ALTER TABLE game_sessions DROP last_skipped_at');
        $this->addSql('ALTER TABLE players DROP points');
        $this->addSql('ALTER TABLE players DROP current_streak');
        $this->addSql('ALTER INDEX idx_264e43a68fe32b32 RENAME TO idx_264e43a67e5a734c');
    }
}
