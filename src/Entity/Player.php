<?php

namespace App\Entity;

use App\Repository\PlayerRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PlayerRepository::class)]
#[ORM\Table(name: 'players')]
class Player
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 36)]
    private string $id;

    #[ORM\Column(type: 'string', length: 50)]
    private string $name;

    #[ORM\Column(type: 'integer')]
    private int $score = 0;

    #[ORM\Column(type: 'integer')]
    private int $points = 0;

    #[ORM\Column(type: 'integer')]
    private int $currentStreak = 0;

    #[ORM\Column(type: 'integer')]
    private int $hintsUsed = 0;

    #[ORM\Column(type: 'integer')]
    private int $skipsUsed = 0;

    #[ORM\Column(type: 'boolean')]
    private bool $isHost = false;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $joinedAt;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $lastSeenAt;

    #[ORM\Column(type: 'string', length: 7)]
    private string $color;

    #[ORM\ManyToOne(targetEntity: GameSession::class, inversedBy: 'players')]
    #[ORM\JoinColumn(nullable: false, onDelete: 'CASCADE')]
    private ?GameSession $gameSession = null;

    private const COLORS = [
        '#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4',
        '#FFEAA7', '#DDA0DD', '#98D8C8', '#F7DC6F'
    ];

    // Point system constants
    public const POINTS_CORRECT_ANSWER = 20;
    public const POINTS_HINT_PENALTY = -3;
    public const POINTS_SKIP_PENALTY = -10;
    public const STREAK_BONUS_2 = 5;
    public const STREAK_BONUS_3 = 10;
    public const STREAK_BONUS_4_PLUS = 15;

    public function __construct()
    {
        $this->id = $this->generateId();
        $this->joinedAt = new \DateTime();
        $this->lastSeenAt = new \DateTime();
        $this->color = self::COLORS[array_rand(self::COLORS)];
    }

    private function generateId(): string
    {
        return sprintf(
            '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand(0, 0xffff), mt_rand(0, 0xffff),
            mt_rand(0, 0xffff),
            mt_rand(0, 0x0fff) | 0x4000,
            mt_rand(0, 0x3fff) | 0x8000,
            mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff)
        );
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function getScore(): int
    {
        return $this->score;
    }

    public function incrementScore(): self
    {
        $this->score++;
        return $this;
    }

    public function getPoints(): int
    {
        return $this->points;
    }

    public function addPoints(int $amount): self
    {
        $this->points += $amount;
        return $this;
    }

    public function getCurrentStreak(): int
    {
        return $this->currentStreak;
    }

    public function incrementStreak(): self
    {
        $this->currentStreak++;
        return $this;
    }

    public function resetStreak(): self
    {
        $this->currentStreak = 0;
        return $this;
    }

    public function calculateStreakBonus(): int
    {
        return match (true) {
            $this->currentStreak >= 4 => self::STREAK_BONUS_4_PLUS,
            $this->currentStreak === 3 => self::STREAK_BONUS_3,
            $this->currentStreak === 2 => self::STREAK_BONUS_2,
            default => 0,
        };
    }

    public function getHintsUsed(): int
    {
        return $this->hintsUsed;
    }

    public function incrementHintsUsed(): self
    {
        $this->hintsUsed++;
        return $this;
    }

    public function getSkipsUsed(): int
    {
        return $this->skipsUsed;
    }

    public function incrementSkipsUsed(): self
    {
        $this->skipsUsed++;
        return $this;
    }

    public function isHost(): bool
    {
        return $this->isHost;
    }

    public function setIsHost(bool $isHost): self
    {
        $this->isHost = $isHost;
        return $this;
    }

    public function getJoinedAt(): \DateTimeInterface
    {
        return $this->joinedAt;
    }

    public function getLastSeenAt(): \DateTimeInterface
    {
        return $this->lastSeenAt;
    }

    public function updateLastSeen(): self
    {
        $this->lastSeenAt = new \DateTime();
        return $this;
    }

    public function getColor(): string
    {
        return $this->color;
    }

    public function setColor(string $color): self
    {
        $this->color = $color;
        return $this;
    }

    public function getGameSession(): ?GameSession
    {
        return $this->gameSession;
    }

    public function setGameSession(?GameSession $gameSession): self
    {
        $this->gameSession = $gameSession;
        return $this;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'score' => $this->score,
            'points' => $this->points,
            'streak' => $this->currentStreak,
            'hintsUsed' => $this->hintsUsed,
            'skipsUsed' => $this->skipsUsed,
            'isHost' => $this->isHost,
            'color' => $this->color,
        ];
    }
}
