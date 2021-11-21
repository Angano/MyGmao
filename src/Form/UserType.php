<?php

namespace App\Form;

use App\Entity\User;
use Doctrine\DBAL\Types\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Twig\Node\Expression\Binary\SubBinary;

class UserType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email')
            ->add(
                'roles',
                ChoiceType::class,
                [
                    'choices'  => [
                        'User' => 'ROLE_USER',
                        'Technicien'    => 'ROLE_TECHNICIEN',
                        'Manager' => 'ROLE_MANAGER',
                        'Admin'     => 'ROLE_ADMIN',
                        'Super admin'    => 'ROLE_SUPER_ADMIN',
                    ],
                    'multiple' => true,
                ]
            )
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent correspondre',
                'first_options' => ['label' => 'Password'],
                'second_options' => ['label' => 'Confirm password']

            ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn-sm btn-primary mx-1'],
                'label' => 'Enregistrer'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}
