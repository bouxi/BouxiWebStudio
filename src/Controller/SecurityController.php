<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * Page de connexion.
     *
     * - Affiche le formulaire de login
     * - Remonte les éventuelles erreurs (mauvais mot de passe, etc.)
     */
    #[Route('/login', name: 'app_login')]
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        // Si l'utilisateur est déjà connecté, on le renvoie vers la home
        if ($this->getUser()) {
            return $this->redirectToRoute('app_home'); // on créera cette route
        }

        // Récupère la dernière erreur de login (s'il y en a une)
        $error = $authenticationUtils->getLastAuthenticationError();

        // Dernier email saisi par l'utilisateur
        $lastUsername = $authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', [
            'last_username' => $lastUsername,
            'error'         => $error,
        ]);
    }

    /**
     * Route de déconnexion.
     *
     * ⚠️ Ce code ne sera jamais exécuté :
     * Symfony intercepte la route /logout automatiquement.
     */
    #[Route('/logout', name: 'app_logout')]
    public function logout(): void
    {
        // Laisse vide : Symfony gère la déconnexion.
    }
}
