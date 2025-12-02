<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\ContactMessage;
use App\Form\ContactType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
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
     *
     * - Affiche le formulaire de contact
     * - Valide les données
     * - Enregistre le message en BDD
     * - Envoie un e-mail de notification au propriétaire du site
     */
    #[Route('/contact', name: 'app_contact')]
    public function contact(
        Request $request,
        EntityManagerInterface $em,
        MailerInterface $mailer
    ): Response {
        // 1. On crée un nouvel objet ContactMessage vide
        $contact = new ContactMessage();

        // 2. On crée le formulaire basé sur ContactType
        $form = $this->createForm(ContactType::class, $contact);

        // 3. On demande au formulaire de traiter la requête HTTP (GET ou POST)
        $form->handleRequest($request);

        // 4. Si le formulaire a été soumis et est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // createdAt et isRead sont déjà initialisés dans le constructeur

            // 5. On persiste et flush en base de données
            $em->persist($contact);
            $em->flush();

            // 6. On prépare l'e-mail de notification
            //    ⚠️ Remplace l'adresse "owner@example.com" par ton e-mail perso
            $email = (new TemplatedEmail())
                ->from(new Address('no-reply@bouxiwebstudio.local', 'BouxiWebStudio'))
                ->to(new Address('owner@example.com', 'BouxiWebStudio')) // à remplacer
                ->subject('[BouxiWebStudio] Nouveau message de contact')
                // Template Twig utilisé pour le contenu HTML
                ->htmlTemplate('emails/contact_notification.html.twig')
                // Données passées au template (variable "contact")
                ->context([
                    'contact' => $contact,
                ]);

            try {
                // 7. Envoi de l'e-mail via le service Mailer
                $mailer->send($email);

                // 8. Message de confirmation pour l'utilisateur
                $this->addFlash('success', 'Merci, votre message a bien été envoyé !');
            } catch (\Throwable $e) {
                // En cas d'erreur d'envoi, on loguerait ça plus tard
                // mais on informe l'utilisateur sans tout casser.
                $this->addFlash(
                    'danger',
                    'Votre message a été enregistré, mais une erreur est survenue lors de l’envoi de l’e-mail.'
                );
            }

            // 9. Redirection pour éviter que F5 renvoie le formulaire
            return $this->redirectToRoute('app_contact');
        }

        // 10. Affichage du formulaire (GET initial ou formulaire non valide)
        return $this->render('pages/contact.html.twig', [
            'contactForm' => $form->createView(),
        ]);
    }

}
