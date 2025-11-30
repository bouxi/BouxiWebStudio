<?php


namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Formulaire d'inscription.
 * On utilise un "plainPassword" non mappé à l'entité,
 * qui sera hashé dans le contrôleur avant d'être stocké.
 */
class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullname', TextType::class, [
                'label' => 'Nom complet',
                'constraints' => [
                    new Assert\NotBlank(message: 'Merci d’indiquer votre nom complet.'),
                    new Assert\Length(
                        min: 3,
                        minMessage: 'Le nom doit contenir au moins {{ limit }} caractères.'
                    ),
                ],
            ])
            ->add('email', EmailType::class, [
                'label' => 'E-mail',
                'constraints' => [
                    new Assert\NotBlank(message: 'Merci d’indiquer votre adresse e-mail.'),
                    new Assert\Email(message: 'Adresse e-mail invalide.'),
                ],
            ])
            ->add('plainPassword', RepeatedType::class, [
                'type' => PasswordType::class,
                'mapped' => false, // ⚠️ pas directement lié à l'entité User
                'invalid_message' => 'Les mots de passe doivent correspondre.',
                'first_options' => [
                    'label' => 'Mot de passe',
                ],
                'second_options' => [
                    'label' => 'Confirmer le mot de passe',
                ],
                'constraints' => [
                    new Assert\NotBlank(message: 'Merci de choisir un mot de passe.'),
                    new Assert\Length(
                        min: 8,
                        minMessage: 'Le mot de passe doit contenir au moins {{ limit }} caractères.'
                    ),
                ],
            ])
            ->add('agreeTerms', CheckboxType::class, [
                'label' => 'J’accepte les conditions générales',
                'mapped' => false,
                'constraints' => [
                    new Assert\IsTrue(message: 'Vous devez accepter les conditions pour continuer.'),
                ],
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
