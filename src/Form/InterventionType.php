<?php

namespace App\Form;

use App\Entity\Client;
use App\Entity\Materiel;
use App\Entity\Technicien;
use App\Entity\Intervention;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class InterventionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, array(
                'widget' => 'single_text',
                'html5' => false,
                'label' => 'Date de demande (JJ/MM/AAAA)*',
                'format' => 'dd-MM-yyyy',
            ))
            /* ->add('status', CheckboxType::class, [
                'attr' => [
                    'class' => "form-check-input",
                    'role' => "switch",
                ],
                'label' => 'Terminée',
                'label_attr' => ['class' => "form-check-label"],
                'required'=>false
            ]) */
            ->add('symptome',TextareaType::class,[
                'attr'=>[
                    'rows'=>10,
                ],
            ])
            /* ->add('travaux',TextareaType::class,[
                'attr'=>[
                    'rows'=>10,
                ],
            ])
            ->add('compteur') */
            ->add('materiel', EntityType::class, [
                'class' => Materiel::class,
                'choice_label' => 'id',
                'attr'=>[
                    'class'=>' data_materiel d-none',
                    'required'=>"required",
                ],
                
            ])
            ->add('technicien', EntityType::class, [
                'class' => Technicien::class,
                'choice_label' => 'id',
                'attr'=>[
                    'class'=>'d-none'
                ]
            ])
            ->add('client', EntityType::class, [
                'class' => Client::class,
                'choice_label' => 'id',
                'attr'=>['class'=>'d-none']
            ])
            ->add('enregistrer', SubmitType::class, ['attr' => ['class' => 'btn btn-sm btn-success']]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Intervention::class,
        ]);
    }
}
