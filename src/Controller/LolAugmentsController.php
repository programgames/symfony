<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Optimisations (augments) de l'ARAM du chaos, en français, présentées comme le wiki League of Legends.
 * Données : data/lol_mayhem_augments.json (traduction du wiki + optimisations du PBE).
 */
final class LolAugmentsController extends AbstractController
{
    private const DATA_FILE = '/data/lol_mayhem_augments.json';

    #[Route('/lol/augments', name: 'app_lol_augments')]
    public function index(): Response
    {
        $path = dirname(__DIR__, 2).self::DATA_FILE;
        $data = json_decode((string) file_get_contents($path), true, 512, \JSON_THROW_ON_ERROR);

        return $this->render('lol/augments.html.twig', $data);
    }

    /** Ancienne page statique. */
    #[Route('/lol_mayhem_augments_fr.html', name: 'app_lol_augments_legacy')]
    public function legacy(): RedirectResponse
    {
        return $this->redirectToRoute('app_lol_augments', [], Response::HTTP_MOVED_PERMANENTLY);
    }
}
