<?php

namespace App\Form;

use App\Entity\Client;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ClientType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('societe')
            ->add('nom')
            ->add('prenom')
            ->add('adresse')
            ->add('codepostal')
            ->add('ville')
            ->add('telephone')
            ->add('mail')
            ->add('information')
            ->add('enregistrer',SubmitType::class,[
                'attr'=>['class'=>'btn btn-sm btn-success']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Client::class,
        ]);
    }
}
