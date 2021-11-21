<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Materiel;
use Symfony\Component\Form\AbstractType;
use App\Entity\Materieltype as Equipement;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;


class MaterielType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('matricule', TextType::class, ['attr' => ['placeholder' => 'Matricule']])
            ->add('infos', TextareaType::class, ['required'=>false,'attr' => [ 'cols' => '10', 'rows' => '9', 'style' => 'width:100%', 'placeholder' => 'Informations complétentaire']])
            ->add('compteur', IntegerType::class, ['attr' => ['placeholder' => 'Compteur']])
            ->add('materieltype', EntityType::class, [
                'class' => Equipement::class,
                'choice_label' => 'marque',
                'attr'=>['class'=>'d-none'],
            ])
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'societe',
                'attr' => ['class' => 'd-none']
            ])
            ->add('enregistrer', SubmitType::class, ['attr' => ['class' => 'btn btn-sm btn-success']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Materiel::class,
        ]);
    }
}
