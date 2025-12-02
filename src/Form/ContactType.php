<?php

namespace App\Form;

use App\Entity\ContactMessage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Formulaire de contact public.
 * On mappe directement sur l'entité ContactMessage.
 */
class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            // Champ "nom complet"
            ->add('fullname', TextType::class, [
                'label' => 'Nom complet',
                'constraints' => [
                    new Assert\NotBlank(message: 'Merci d’indiquer votre nom.'),
                    new Assert\Length(
                        min: 3,
                        minMessage: 'Le nom doit contenir au moins {{ limit }} caractères.'
                    ),
                ],
            ])

            // Champ e-mail
            ->add('email', EmailType::class, [
                'label' => 'E-mail',
                'constraints' => [
                    new Assert\NotBlank(message: 'Merci d’indiquer votre adresse e-mail.'),
                    new Assert\Email(message: 'Adresse e-mail invalide.'),
                ],
            ])

            // Sujet du message
            ->add('subject', TextType::class, [
                'label' => 'Sujet',
                'constraints' => [
                    new Assert\NotBlank(message: 'Merci d’indiquer un sujet.'),
                    new Assert\Length(
                        min: 5,
                        minMessage: 'Le sujet doit contenir au moins {{ limit }} caractères.'
                    ),
                ],
            ])

            // Contenu du message
            ->add('message', TextareaType::class, [
                'label' => 'Message',
                'attr' => [
                    'rows' => 5,
                ],
                'constraints' => [
                    new Assert\NotBlank(message: 'Merci de saisir un message.'),
                    new Assert\Length(
                        min: 10,
                        minMessage: 'Le message doit contenir au moins {{ limit }} caractères.'
                    ),
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // On lie le formulaire à l'entité ContactMessage
            'data_class' => ContactMessage::class,
        ]);
    }
}
