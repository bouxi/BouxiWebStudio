<?php

namespace App\Controller;

use App\Repository\ContactMessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class AccountController extends AbstractController
{
    /**
     * Tableau de bord utilisateur.
     * Accessible uniquement si l'utilisateur est connecté (ROLE_USER).
     */
    #[Route('/dashboard', name: 'app_dashboard')]
    #[IsGranted('ROLE_USER')]
    public function dashboard(ContactMessageRepository $contactRepo): Response
    {
        // Récupère l'utilisateur actuellement connecté
        $user = $this->getUser();

        // Par sécurité, si pas d'utilisateur (ne devrait pas arriver avec IsGranted)
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        // On récupère quelques statistiques simples
        $email = $user->getEmail();

        // Derniers messages de contact envoyés avec cet email
        $lastMessages = $contactRepo->findLastByEmail($email, 5);

        // Nombre total de messages envoyés par cet email
        $totalMessages = count($contactRepo->findLastByEmail($email, 1000)); // simple mais suffisant pour l'instant

        return $this->render('account/dashboard.html.twig', [
            'user'          => $user,
            'lastMessages'  => $lastMessages,
            'totalMessages' => $totalMessages,
        ]);
    }
}
