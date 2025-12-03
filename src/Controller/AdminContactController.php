<?php

namespace App\Controller;

use App\Repository\ContactMessageRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

/**
 * Contrôleur pour la gestion des messages de contact côté admin.
 * Toutes les routes de ce contrôleur commencent par /admin/contact
 * et sont réservées au rôle ROLE_ADMIN.
 */
#[Route('/admin/contact')]
#[IsGranted('ROLE_ADMIN')]
class AdminContactController extends AbstractController
{
    /**
     * Liste tous les messages de contact.
     *
     * URL : /admin/contact
     * Nom de route : admin_contact_index
     */
    #[Route('/', name: 'admin_contact_index')]
    public function index(ContactMessageRepository $contactRepo): Response
    {
        // On va chercher tous les messages, triés du plus récent au plus ancien
        $messages = $contactRepo->findBy([], ['createdAt' => 'DESC']);

        return $this->render('admin/contact/index.html.twig', [
            'messages' => $messages,
        ]);
    }
}
