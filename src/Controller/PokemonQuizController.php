<?php

namespace App\Controller;

use App\Pokemon\PokemonData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/pokemon-quiz', name: 'pokemon_quiz_')]
final class PokemonQuizController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(): Response
    {
        $generations = PokemonData::getGenerations();

        return $this->render('pokemon_quiz/index.html.twig', [
            'generations' => $generations,
        ]);
    }

    #[Route('/play/{generation}', name: 'play', requirements: ['generation' => '\d+'])]
    public function play(int $generation): Response
    {
        $generations = PokemonData::getGenerations();

        if (!isset($generations[$generation]) || !$generations[$generation]['available']) {
            $this->addFlash('error', 'Cette génération n\'est pas encore disponible.');
            return $this->redirectToRoute('pokemon_quiz_index');
        }

        $pokemon = PokemonData::getPokemonForGeneration($generation);
        $count = PokemonData::getGenerationCount($generation);

        // Add types to each Pokemon
        foreach ($pokemon as $id => &$data) {
            $data['types'] = PokemonData::getPokemonTypesTranslated($id);
        }

        return $this->render('pokemon_quiz/play.html.twig', [
            'generation' => $generation,
            'generationName' => $generations[$generation]['name'],
            'pokemonData' => $pokemon,
            'totalCount' => $count,
        ]);
    }

    #[Route('/check-answer', name: 'check_answer', methods: ['POST'])]
    public function checkAnswer(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $pokemonId = $data['pokemonId'] ?? null;
        $answer = $data['answer'] ?? '';
        $language = $data['language'] ?? 'fr';

        if ($pokemonId === null) {
            return new JsonResponse(['error' => 'Missing pokemonId'], 400);
        }

        $isCorrect = PokemonData::checkAnswer($answer, (int) $pokemonId, $language);
        $correctName = PokemonData::getPokemonName((int) $pokemonId, $language);

        return new JsonResponse([
            'correct' => $isCorrect,
            'pokemonName' => $correctName,
            'pokemonId' => $pokemonId,
        ]);
    }
}
