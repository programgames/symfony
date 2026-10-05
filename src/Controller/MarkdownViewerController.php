<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

final class MarkdownViewerController extends AbstractController
{
    /**
     * Documents markdown consultables, indexés par slug.
     *
     * @var array<string, array{file: string, title: string}>
     */
    private const DOCS = [
        'meatballcraft' => [
            'file' => 'TIPS-MEATBALLCRAFT-FR.md',
            'title' => 'MeatballCraft — Tips & choix d\'options',
        ],
    ];

    #[Route('/tips', name: 'app_markdown_viewer')]
    public function index(#[MapQueryParameter] string $doc = 'meatballcraft'): Response
    {
        if (!isset(self::DOCS[$doc])) {
            throw $this->createNotFoundException(sprintf('Document "%s" inconnu.', $doc));
        }

        $path = $this->getParameter('kernel.project_dir').'/public/'.self::DOCS[$doc]['file'];

        if (!is_file($path)) {
            throw $this->createNotFoundException(sprintf('Fichier "%s" introuvable.', self::DOCS[$doc]['file']));
        }

        return $this->render('markdown_viewer/index.html.twig', [
            'title' => self::DOCS[$doc]['title'],
            'markdown' => file_get_contents($path),
        ]);
    }
}
