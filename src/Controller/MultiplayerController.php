<?php

namespace App\Controller;

use App\Entity\GameSession;
use App\Entity\Player;
use App\Pokemon\PokemonData;
use App\Repository\GameSessionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/pokemon-quiz/multiplayer', name: 'pokemon_quiz_mp_')]
final class MultiplayerController extends AbstractController
{
    public function __construct(
        private readonly EntityManagerInterface $em,
        private readonly GameSessionRepository $gameSessionRepository,
    ) {}

    #[Route('/create', name: 'create', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $playerName = trim($data['playerName'] ?? '');
        $generation = (int) ($data['generation'] ?? 1);

        if (empty($playerName) || mb_strlen($playerName) > 50) {
            return new JsonResponse(['error' => 'Pseudo invalide'], 400);
        }

        $generations = PokemonData::getGenerations();
        if (!isset($generations[$generation]) || !$generations[$generation]['available']) {
            return new JsonResponse(['error' => 'Generation invalide'], 400);
        }

        // Create game session
        $session = new GameSession();
        $session->setGeneration($generation);
        $session->setRemainingPokemon(PokemonData::getPokemonIdsForGeneration($generation));

        // Create host player
        $player = new Player();
        $player->setName($playerName);
        $player->setIsHost(true);
        $session->addPlayer($player);

        $this->em->persist($session);
        $this->em->persist($player);
        $this->em->flush();

        return new JsonResponse([
            'sessionId' => $session->getId(),
            'playerId' => $player->getId(),
            'playerColor' => $player->getColor(),
        ]);
    }

    #[Route('/join/{sessionId}', name: 'join', methods: ['POST'])]
    public function join(string $sessionId, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $playerName = trim($data['playerName'] ?? '');

        if (empty($playerName) || mb_strlen($playerName) > 50) {
            return new JsonResponse(['error' => 'Pseudo invalide'], 400);
        }

        $session = $this->gameSessionRepository->find($sessionId);
        if (!$session) {
            return new JsonResponse(['error' => 'Partie introuvable'], 404);
        }

        if ($session->getPlayers()->count() >= 8) {
            return new JsonResponse(['error' => 'Partie complete (8 joueurs max)'], 400);
        }

        if ($session->isFinished()) {
            return new JsonResponse(['error' => 'Partie terminee'], 400);
        }

        // Create player
        $player = new Player();
        $player->setName($playerName);
        $session->addPlayer($player);

        $session->addActivity('join', $player->getId(), $playerName);
        $session->setUpdatedAt(new \DateTime());

        $this->em->persist($player);
        $this->em->flush();

        return new JsonResponse([
            'sessionId' => $session->getId(),
            'playerId' => $player->getId(),
            'playerColor' => $player->getColor(),
            'generation' => $session->getGeneration(),
        ]);
    }

    #[Route('/session/{sessionId}', name: 'session_info', methods: ['GET'])]
    public function sessionInfo(string $sessionId): JsonResponse
    {
        $session = $this->gameSessionRepository->find($sessionId);
        if (!$session) {
            return new JsonResponse(['error' => 'Partie introuvable'], 404);
        }

        return new JsonResponse([
            'sessionId' => $session->getId(),
            'generation' => $session->getGeneration(),
            'playerCount' => $session->getPlayers()->count(),
            'isStarted' => $session->isStarted(),
            'isFinished' => $session->isFinished(),
        ]);
    }

    #[Route('/play/{sessionId}', name: 'play')]
    public function play(string $sessionId, Request $request): Response
    {
        $session = $this->gameSessionRepository->find($sessionId);
        if (!$session) {
            $this->addFlash('error', 'Partie introuvable');
            return $this->redirectToRoute('pokemon_quiz_index');
        }

        $playerId = $request->query->get('player');
        $player = null;
        if ($playerId) {
            foreach ($session->getPlayers() as $p) {
                if ($p->getId() === $playerId) {
                    $player = $p;
                    break;
                }
            }
        }

        $generations = PokemonData::getGenerations();
        $generation = $session->getGeneration();
        $pokemon = PokemonData::getPokemonForGeneration($generation);

        // Add types to each Pokemon
        foreach ($pokemon as $id => &$data) {
            $data['types'] = PokemonData::getPokemonTypesTranslated($id);
        }

        return $this->render('pokemon_quiz/multiplayer.html.twig', [
            'session' => $session,
            'player' => $player,
            'generation' => $generation,
            'generationName' => $generations[$generation]['name'],
            'pokemonData' => $pokemon,
            'totalCount' => PokemonData::getGenerationCount($generation),
        ]);
    }

    #[Route('/start/{sessionId}', name: 'start', methods: ['POST'])]
    public function start(string $sessionId, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $playerId = $data['playerId'] ?? '';

        $session = $this->gameSessionRepository->find($sessionId);
        if (!$session) {
            return new JsonResponse(['error' => 'Partie introuvable'], 404);
        }

        // Check if player is host
        $isHost = false;
        foreach ($session->getPlayers() as $player) {
            if ($player->getId() === $playerId && $player->isHost()) {
                $isHost = true;
                break;
            }
        }

        if (!$isHost) {
            return new JsonResponse(['error' => 'Seul l\'hote peut lancer la partie'], 403);
        }

        if ($session->isStarted()) {
            return new JsonResponse(['error' => 'Partie deja lancee'], 400);
        }

        // Start the game
        $session->setIsStarted(true);
        $session->setStartedAt(new \DateTime());
        $nextPokemon = $session->getNextPokemon();
        $session->setCurrentPokemonId($nextPokemon);
        $session->setUpdatedAt(new \DateTime());

        $this->em->flush();

        return new JsonResponse([
            'success' => true,
            'currentPokemonId' => $nextPokemon,
        ]);
    }

    #[Route('/state/{sessionId}', name: 'state', methods: ['GET'])]
    public function state(string $sessionId, Request $request): JsonResponse
    {
        $playerId = $request->query->get('playerId');

        $session = $this->gameSessionRepository->find($sessionId);
        if (!$session) {
            return new JsonResponse(['error' => 'Partie introuvable'], 404);
        }

        // Update player last seen
        foreach ($session->getPlayers() as $player) {
            if ($player->getId() === $playerId) {
                $player->updateLastSeen();
                break;
            }
        }
        $this->em->flush();

        $players = [];
        foreach ($session->getPlayers() as $player) {
            $players[] = $player->toArray();
        }

        // Sort players by points (new point system)
        usort($players, fn($a, $b) => $b['points'] - $a['points']);

        // Prepare last skipped info (only if within 3 seconds)
        $lastSkippedPokemonName = null;
        $lastSkippedAt = $session->getLastSkippedAt();
        if ($lastSkippedAt !== null) {
            $now = new \DateTime();
            $diff = $now->getTimestamp() - $lastSkippedAt->getTimestamp();
            if ($diff <= 3) {
                $lastSkippedPokemonName = $session->getLastSkippedPokemonName();
            }
        }

        // Load similar cries data
        $similarCries = null;
        $currentPokemonId = $session->getCurrentPokemonId();
        if ($currentPokemonId !== null) {
            $similarCriesPath = __DIR__ . '/../../data/similar_cries.json';
            if (file_exists($similarCriesPath)) {
                $allSimilarCries = json_decode(file_get_contents($similarCriesPath), true);
                if (isset($allSimilarCries[$currentPokemonId])) {
                    $similarCries = $allSimilarCries[$currentPokemonId];
                }
            }
        }

        return new JsonResponse([
            'isStarted' => $session->isStarted(),
            'isFinished' => $session->isFinished(),
            'currentPokemonId' => $session->getCurrentPokemonId(),
            'foundPokemon' => $session->getFoundPokemon(),
            'players' => $players,
            'activityLog' => array_slice($session->getActivityLog(), 0, 10),
            'totalHintsUsed' => $session->getTotalHintsUsed(),
            'totalSkipsUsed' => $session->getTotalSkipsUsed(),
            'elapsedTime' => $session->getElapsedTime(),
            'updatedAt' => $session->getUpdatedAt()->format('c'),
            'currentHint' => $session->getCurrentHint(),
            'lastSkippedPokemonName' => $lastSkippedPokemonName,
            'lastSkippedAt' => $lastSkippedAt?->format('c'),
            'similarCries' => $similarCries,
        ]);
    }

    #[Route('/answer/{sessionId}', name: 'answer', methods: ['POST'])]
    public function answer(string $sessionId, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $playerId = $data['playerId'] ?? '';
        $answer = $data['answer'] ?? '';

        $session = $this->gameSessionRepository->find($sessionId);
        if (!$session) {
            return new JsonResponse(['error' => 'Partie introuvable'], 404);
        }

        if (!$session->isStarted() || $session->isFinished()) {
            return new JsonResponse(['error' => 'Partie non active'], 400);
        }

        $currentPokemonId = $session->getCurrentPokemonId();
        if (!$currentPokemonId) {
            return new JsonResponse(['error' => 'Aucun Pokemon en cours'], 400);
        }

        // Find player
        $player = null;
        foreach ($session->getPlayers() as $p) {
            if ($p->getId() === $playerId) {
                $player = $p;
                break;
            }
        }

        if (!$player) {
            return new JsonResponse(['error' => 'Joueur introuvable'], 404);
        }

        // Check answer
        $isCorrect = PokemonData::checkAnswer($answer, $currentPokemonId);

        if ($isCorrect) {
            $pokemonName = PokemonData::getPokemonName($currentPokemonId);

            // Update session
            $session->addFoundPokemon($currentPokemonId, $playerId, $pokemonName);
            $session->addActivity('found', $playerId, $player->getName(), $pokemonName);

            // Update player score and points
            $player->incrementScore();
            $player->incrementStreak();
            $bonus = $player->calculateStreakBonus();
            $player->addPoints(Player::POINTS_CORRECT_ANSWER + $bonus);

            // Reset hint for next pokemon
            $session->setCurrentHint(null);
            $session->setLastSkippedPokemonName(null);
            $session->setLastSkippedAt(null);

            // Get next pokemon or finish
            $nextPokemon = $session->getNextPokemon();
            if ($nextPokemon) {
                $session->setCurrentPokemonId($nextPokemon);
            } else {
                $session->setCurrentPokemonId(null);
                $session->setIsFinished(true);
                $session->setFinishedAt(new \DateTime());
            }

            $session->setUpdatedAt(new \DateTime());
            $this->em->flush();

            return new JsonResponse([
                'correct' => true,
                'pokemonName' => $pokemonName,
                'pokemonId' => $currentPokemonId,
                'nextPokemonId' => $nextPokemon,
                'isFinished' => $session->isFinished(),
                'pointsAwarded' => Player::POINTS_CORRECT_ANSWER + $bonus,
                'streakBonus' => $bonus,
            ]);
        }

        return new JsonResponse(['correct' => false]);
    }

    #[Route('/hint/{sessionId}', name: 'hint', methods: ['POST'])]
    public function hint(string $sessionId, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $playerId = $data['playerId'] ?? '';

        $session = $this->gameSessionRepository->find($sessionId);
        if (!$session) {
            return new JsonResponse(['error' => 'Partie introuvable'], 404);
        }

        if (!$session->isStarted() || $session->isFinished()) {
            return new JsonResponse(['error' => 'Partie non active'], 400);
        }

        // Find player
        $player = null;
        foreach ($session->getPlayers() as $p) {
            if ($p->getId() === $playerId) {
                $player = $p;
                break;
            }
        }

        $currentPokemonId = $session->getCurrentPokemonId();
        $types = $currentPokemonId ? PokemonData::getPokemonTypesTranslated($currentPokemonId) : [];

        if ($player) {
            $player->incrementHintsUsed();
            $player->addPoints(Player::POINTS_HINT_PENALTY);
            $session->incrementHintsUsed();
            $session->setCurrentHint($types);
            $session->addActivity('hint', $playerId, $player->getName());
            $session->setUpdatedAt(new \DateTime());
            $this->em->flush();
        }

        return new JsonResponse([
            'success' => true,
            'types' => $types,
        ]);
    }

    #[Route('/skip/{sessionId}', name: 'skip', methods: ['POST'])]
    public function skip(string $sessionId, Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $playerId = $data['playerId'] ?? '';

        $session = $this->gameSessionRepository->find($sessionId);
        if (!$session) {
            return new JsonResponse(['error' => 'Partie introuvable'], 404);
        }

        if (!$session->isStarted() || $session->isFinished()) {
            return new JsonResponse(['error' => 'Partie non active'], 400);
        }

        // Find player
        $player = null;
        foreach ($session->getPlayers() as $p) {
            if ($p->getId() === $playerId) {
                $player = $p;
                break;
            }
        }

        $currentPokemonId = $session->getCurrentPokemonId();
        $pokemonName = $currentPokemonId ? PokemonData::getPokemonName($currentPokemonId) : null;

        if ($player) {
            $player->incrementSkipsUsed();
            $player->addPoints(Player::POINTS_SKIP_PENALTY);
            $player->resetStreak();
            $session->incrementSkipsUsed();
            $session->addActivity('skip', $playerId, $player->getName(), $pokemonName);
        }

        // Store the skipped pokemon info for all players to see (3 seconds)
        $session->setLastSkippedPokemonName($pokemonName);
        $session->setLastSkippedAt(new \DateTime());

        // Reset hint for next pokemon
        $session->setCurrentHint(null);

        // Remove from remaining without adding to found
        $remaining = array_filter(
            $session->getRemainingPokemon(),
            fn($id) => $id !== $currentPokemonId
        );
        $session->setRemainingPokemon(array_values($remaining));

        // Get next pokemon
        $nextPokemon = $session->getNextPokemon();
        if ($nextPokemon) {
            $session->setCurrentPokemonId($nextPokemon);
        } else {
            $session->setCurrentPokemonId(null);
            $session->setIsFinished(true);
            $session->setFinishedAt(new \DateTime());
        }

        $session->setUpdatedAt(new \DateTime());
        $this->em->flush();

        return new JsonResponse([
            'success' => true,
            'skippedPokemonId' => $currentPokemonId,
            'skippedPokemonName' => $pokemonName,
            'nextPokemonId' => $nextPokemon,
            'isFinished' => $session->isFinished(),
        ]);
    }
}
