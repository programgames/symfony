<?php

namespace App\Entity;

use App\Repository\GameSessionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: GameSessionRepository::class)]
#[ORM\Table(name: 'game_sessions')]
class GameSession
{
    #[ORM\Id]
    #[ORM\Column(type: 'string', length: 8)]
    private string $id;

    #[ORM\Column(type: 'integer')]
    private int $generation;

    #[ORM\Column(type: 'json')]
    private array $foundPokemon = [];

    #[ORM\Column(type: 'json')]
    private array $remainingPokemon = [];

    #[ORM\Column(type: 'integer', nullable: true)]
    private ?int $currentPokemonId = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $startedAt = null;

    #[ORM\Column(type: 'datetime', nullable: true)]
    private ?\DateTimeInterface $finishedAt = null;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $createdAt;

    #[ORM\Column(type: 'datetime')]
    private \DateTimeInterface $updatedAt;

    #[ORM\Column(type: 'boolean')]
    private bool $isStarted = false;

    #[ORM\Column(type: 'boolean')]
    private bool $isFinished = false;

    #[ORM\Column(type: 'integer')]
    private int $totalHintsUsed = 0;

    #[ORM\Column(type: 'integer')]
    private int $totalSkipsUsed = 0;

    #[ORM\OneToMany(mappedBy: 'gameSession', targetEntity: Player::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $players;

    #[ORM\Column(type: 'json')]
    private array $activityLog = [];

    public function __construct()
    {
        $this->id = $this->generateId();
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->players = new ArrayCollection();
    }

    private function generateId(): string
    {
        $chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        $id = '';
        for ($i = 0; $i < 8; $i++) {
            $id .= $chars[random_int(0, strlen($chars) - 1)];
        }
        return $id;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getGeneration(): int
    {
        return $this->generation;
    }

    public function setGeneration(int $generation): self
    {
        $this->generation = $generation;
        return $this;
    }

    public function getFoundPokemon(): array
    {
        return $this->foundPokemon;
    }

    public function setFoundPokemon(array $foundPokemon): self
    {
        $this->foundPokemon = $foundPokemon;
        return $this;
    }

    public function addFoundPokemon(int $pokemonId, string $playerId, string $pokemonName): self
    {
        $this->foundPokemon[$pokemonId] = [
            'playerId' => $playerId,
            'pokemonName' => $pokemonName,
            'foundAt' => (new \DateTime())->format('c'),
        ];
        $this->remainingPokemon = array_values(array_filter(
            $this->remainingPokemon,
            fn($id) => $id !== $pokemonId
        ));
        return $this;
    }

    public function getRemainingPokemon(): array
    {
        return $this->remainingPokemon;
    }

    public function setRemainingPokemon(array $remainingPokemon): self
    {
        $this->remainingPokemon = $remainingPokemon;
        return $this;
    }

    public function getCurrentPokemonId(): ?int
    {
        return $this->currentPokemonId;
    }

    public function setCurrentPokemonId(?int $currentPokemonId): self
    {
        $this->currentPokemonId = $currentPokemonId;
        return $this;
    }

    public function getStartedAt(): ?\DateTimeInterface
    {
        return $this->startedAt;
    }

    public function setStartedAt(?\DateTimeInterface $startedAt): self
    {
        $this->startedAt = $startedAt;
        return $this;
    }

    public function getFinishedAt(): ?\DateTimeInterface
    {
        return $this->finishedAt;
    }

    public function setFinishedAt(?\DateTimeInterface $finishedAt): self
    {
        $this->finishedAt = $finishedAt;
        return $this;
    }

    public function getCreatedAt(): \DateTimeInterface
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): \DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;
        return $this;
    }

    public function isStarted(): bool
    {
        return $this->isStarted;
    }

    public function setIsStarted(bool $isStarted): self
    {
        $this->isStarted = $isStarted;
        return $this;
    }

    public function isFinished(): bool
    {
        return $this->isFinished;
    }

    public function setIsFinished(bool $isFinished): self
    {
        $this->isFinished = $isFinished;
        return $this;
    }

    public function getTotalHintsUsed(): int
    {
        return $this->totalHintsUsed;
    }

    public function incrementHintsUsed(): self
    {
        $this->totalHintsUsed++;
        return $this;
    }

    public function getTotalSkipsUsed(): int
    {
        return $this->totalSkipsUsed;
    }

    public function incrementSkipsUsed(): self
    {
        $this->totalSkipsUsed++;
        return $this;
    }

    /**
     * @return Collection<int, Player>
     */
    public function getPlayers(): Collection
    {
        return $this->players;
    }

    public function addPlayer(Player $player): self
    {
        if (!$this->players->contains($player)) {
            $this->players->add($player);
            $player->setGameSession($this);
        }
        return $this;
    }

    public function removePlayer(Player $player): self
    {
        if ($this->players->removeElement($player)) {
            if ($player->getGameSession() === $this) {
                $player->setGameSession(null);
            }
        }
        return $this;
    }

    public function getActivityLog(): array
    {
        return $this->activityLog;
    }

    public function addActivity(string $type, string $playerId, string $playerName, ?string $pokemonName = null): self
    {
        array_unshift($this->activityLog, [
            'type' => $type,
            'playerId' => $playerId,
            'playerName' => $playerName,
            'pokemonName' => $pokemonName,
            'timestamp' => (new \DateTime())->format('c'),
        ]);
        // Keep only last 20 activities
        $this->activityLog = array_slice($this->activityLog, 0, 20);
        return $this;
    }

    public function getNextPokemon(): ?int
    {
        if (empty($this->remainingPokemon)) {
            return null;
        }
        $randomIndex = array_rand($this->remainingPokemon);
        return $this->remainingPokemon[$randomIndex];
    }

    public function getElapsedTime(): ?int
    {
        if (!$this->startedAt) {
            return null;
        }
        $end = $this->finishedAt ?? new \DateTime();
        return $end->getTimestamp() - $this->startedAt->getTimestamp();
    }
}
