<?php

namespace App\Controller;

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
    public function dashboard(): Response
    {
        // $this->getUser() retourne l'objet User connecté
        $user = $this->getUser();

        return $this->render('account/dashboard.html.twig', [
            'user' => $user,
        ]);
    }
}

