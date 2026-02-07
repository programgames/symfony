<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20260207120000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create game_sessions and players tables for multiplayer mode';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE game_sessions (
            id VARCHAR(8) NOT NULL,
            generation INT NOT NULL,
            found_pokemon JSON NOT NULL,
            remaining_pokemon JSON NOT NULL,
            current_pokemon_id INT DEFAULT NULL,
            started_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
            finished_at TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL,
            created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
            updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
            is_started BOOLEAN NOT NULL,
            is_finished BOOLEAN NOT NULL,
            total_hints_used INT NOT NULL,
            total_skips_used INT NOT NULL,
            activity_log JSON NOT NULL,
            PRIMARY KEY(id)
        )');

        $this->addSql('CREATE TABLE players (
            id VARCHAR(36) NOT NULL,
            game_session_id VARCHAR(8) NOT NULL,
            name VARCHAR(50) NOT NULL,
            score INT NOT NULL,
            hints_used INT NOT NULL,
            skips_used INT NOT NULL,
            is_host BOOLEAN NOT NULL,
            joined_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
            last_seen_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL,
            color VARCHAR(7) NOT NULL,
            PRIMARY KEY(id)
        )');

        $this->addSql('CREATE INDEX IDX_264E43A67E5A734C ON players (game_session_id)');
        $this->addSql('ALTER TABLE players ADD CONSTRAINT FK_264E43A67E5A734C FOREIGN KEY (game_session_id) REFERENCES game_sessions (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE players DROP CONSTRAINT FK_264E43A67E5A734C');
        $this->addSql('DROP TABLE players');
        $this->addSql('DROP TABLE game_sessions');
    }
}
