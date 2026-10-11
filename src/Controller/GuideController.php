<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Guides d'utilisation pour les membres : RomM et les deux bots Discord.
 */
#[Route('/guides', name: 'app_guide_')]
final class GuideController extends AbstractController
{
    #[Route('/romm', name: 'romm')]
    public function romm(
        #[Autowire(env: 'default::ROMM_GUEST_USERNAME')] ?string $guestUsername,
        #[Autowire(env: 'default::ROMM_GUEST_PASSWORD')] ?string $guestPassword,
    ): Response {
        return $this->render('guides/romm.html.twig', [
            'active_nav' => 'retro',
            'guest_username' => $guestUsername,
            'guest_password' => $guestPassword,
        ]);
    }

    #[Route('/bot-jeux', name: 'bot_jeux')]
    public function botJeux(): Response
    {
        return $this->render('guides/bot_jeux.html.twig', [
            'active_nav' => 'discord',
        ]);
    }

    #[Route('/bot-musique', name: 'bot_musique')]
    public function botMusique(): Response
    {
        return $this->render('guides/bot_musique.html.twig', [
            'active_nav' => 'discord',
        ]);
    }
}
