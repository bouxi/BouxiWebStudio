<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\ContactMessage;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

class PageController extends AbstractController
{
    /**
     * Page Services
     * URL : /services
     */
    #[Route('/services', name: 'app_services')]
    public function services(): Response
    {
        // On retourne simplement le template
        return $this->render('pages/services.html.twig');
    }

    /**
     * Page Portfolio
     * URL : /portfolio
     */
    #[Route('/portfolio', name: 'app_portfolio')]
    public function portfolio(): Response
    {
        return $this->render('pages/portfolio.html.twig');
    }

    /**
     * Page A propos
     * URL : /a-propos
     */
    #[Route('/a-propos', name: 'app_about')]
    public function about(): Response
    {
        return $this->render('pages/about.html.twig');
    }

    /**
     * Page Contact : affiche et traite le formulaire.
     */
    #[Route('/contact', name: 'app_contact')]
    public function contact(Request $request, EntityManagerInterface $em): Response
    {
        // 1. On crée un nouvel objet ContactMessage vide
        $contact = new ContactMessage();

        // 2. On crée le formulaire basé sur ContactType
        $form = $this->createForm(ContactType::class, $contact);

        // 3. On demande au formulaire de traiter la requête HTTP (GET ou POST)
        $form->handleRequest($request);

        // 4. Si le formulaire a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // createdAt et isRead sont déjà initialisés dans le constructeur

            // 5. On persiste et flush en base
            $em->persist($contact);
            $em->flush();

            // 6. Message de confirmation pour l'utilisateur
            $this->addFlash('success', 'Merci, votre message a bien été envoyé !');

            // 7. Redirection pour éviter que F5 renvoie le formulaire
            return $this->redirectToRoute('app_contact');
        }

        // 8. Affichage du formulaire (view Twig)
        return $this->render('pages/contact.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }
}
