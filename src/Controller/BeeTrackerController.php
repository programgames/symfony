<?php

namespace App\Controller;

use App\Bee\BeeData;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Suivi des abeilles obtenues / à faire, avec persistance serveur.
 */
#[Route('/bees')]
final class BeeTrackerController extends AbstractController
{
    /** États autorisés pour une abeille (l'absence de clé = non obtenue). */
    private const STATES = ['owned', 'todo'];

    #[Route('', name: 'app_bees', methods: ['GET'])]
    public function index(): Response
    {
        return $this->render('bee_tracker/index.html.twig', [
            'data' => BeeData::all(),
            'mods' => BeeData::mods(),
            'state' => $this->stateForOutput($this->readState()),
        ]);
    }

    #[Route('/state', name: 'app_bees_state', methods: ['GET'])]
    public function state(): JsonResponse
    {
        return new JsonResponse($this->stateForOutput($this->readState()));
    }

    /**
     * Applique un lot de changements. Corps attendu :
     * {"changes": {"forestry:forest": "owned", "forestry:meadows": null}}
     * Une valeur null retire l'abeille de l'état (= non obtenue).
     */
    #[Route('/state', name: 'app_bees_state_save', methods: ['POST'])]
    public function saveState(Request $request): JsonResponse
    {
        try {
            $payload = json_decode((string) $request->getContent(), true, 512, \JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            return new JsonResponse(['error' => 'JSON invalide'], Response::HTTP_BAD_REQUEST);
        }

        if (!\is_array($payload) || !\is_array($payload['changes'] ?? null)) {
            return new JsonResponse(['error' => 'Champ "changes" manquant'], Response::HTTP_BAD_REQUEST);
        }

        $bees = BeeData::all()['bees'];
        $state = $this->readState();

        foreach ($payload['changes'] as $key => $value) {
            if (!isset($bees[$key])) {
                return new JsonResponse(['error' => sprintf('Abeille inconnue : %s', $key)], Response::HTTP_BAD_REQUEST);
            }

            if ($value === null) {
                unset($state['states'][$key]);
                continue;
            }

            if (!\in_array($value, self::STATES, true)) {
                return new JsonResponse(['error' => sprintf('État invalide : %s', (string) $value)], Response::HTTP_BAD_REQUEST);
            }

            $state['states'][$key] = $value;
        }

        $state['rev']++;
        $state['updatedAt'] = (new \DateTimeImmutable())->format(\DATE_ATOM);

        $this->writeState($state);

        return new JsonResponse($this->stateForOutput($state));
    }

    /** Export du suivi sous forme de fichier JSON téléchargeable. */
    #[Route('/export', name: 'app_bees_export', methods: ['GET'])]
    public function export(): JsonResponse
    {
        $response = new JsonResponse($this->stateForOutput($this->readState()), Response::HTTP_OK, [], false);
        $response->setEncodingOptions(\JSON_PRETTY_PRINT | \JSON_UNESCAPED_SLASHES);
        $response->headers->set('Content-Disposition', 'attachment; filename="bee-tracker.json"');

        return $response;
    }

    /**
     * Un tableau PHP vide se sérialise en `[]` ; côté JS on veut toujours un objet.
     *
     * @param array{states: array<string, string>, rev: int, updatedAt: string|null} $state
     */
    private function stateForOutput(array $state): array
    {
        $state['states'] = (object) $state['states'];

        return $state;
    }

    /**
     * @return array{states: array<string, string>, rev: int, updatedAt: string|null}
     */
    private function readState(): array
    {
        $path = $this->statePath();

        if (!is_file($path)) {
            return ['states' => [], 'rev' => 0, 'updatedAt' => null];
        }

        try {
            $state = json_decode((string) file_get_contents($path), true, 512, \JSON_THROW_ON_ERROR);
        } catch (\JsonException) {
            return ['states' => [], 'rev' => 0, 'updatedAt' => null];
        }

        return [
            'states' => \is_array($state['states'] ?? null) ? $state['states'] : [],
            'rev' => (int) ($state['rev'] ?? 0),
            'updatedAt' => $state['updatedAt'] ?? null,
        ];
    }

    private function writeState(array $state): void
    {
        $path = $this->statePath();
        $tmp = $path.'.'.bin2hex(random_bytes(4)).'.tmp';

        file_put_contents($tmp, json_encode($state, \JSON_PRETTY_PRINT | \JSON_UNESCAPED_SLASHES | \JSON_THROW_ON_ERROR));
        rename($tmp, $path);
    }

    private function statePath(): string
    {
        return $this->getParameter('kernel.project_dir').'/var/bee_tracker.json';
    }
}
