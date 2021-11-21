<?php

namespace App\Form;

use App\Entity\Materieltype;
use phpDocumentor\Reflection\Types\Null_;
use PHPUnit\TextUI\XmlConfiguration\File;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaterieltypeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('marque', TextType::class, [
                'attr' => [
                    'placeholder' => "Marque",
                    'autocomplete' => 'off',
                ],

            ])
            ->add('modele', TextType::class, [
                'attr' => [
                    'placehoolder' => 'Modèle'
                ]
            ])
            ->add('categorie', TextType::class, ['attr' => [
                'placeholder' => "Catégorie",
                'autocomplete' => 'off',
            ]])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'placeholder' => "Description",
                    'rows' => '8'
                ],

                "required" => false
            ])
            ->add('photo_titre', TextType::class, [
                'attr' => [
                    'placeholder' => "Titre photo"
                ],
                "required" => false,
                'label' => 'Titre',
            ])
            ->add('photo_description', TextareaType::class, [
                'attr' => [
                    'placeholder' => "Description photo",
                    'rows' => '8'
                ],
                "required" => false,
                'label' => 'Description',
            ])
            ->add('photo', FileType::class, [
                'required' => false,
                'data_class' => Null,
            ])
            ->add('document_titre', TextType::class, [
                'attr' => [
                    'placeholder' => "Titre document",
                ],
                'label' => 'Titre',
                "required" => false
            ])
            ->add('document_description', TextareaType::class, [
                'attr' => [
                    'placeholder' => "Description document",
                    'rows' => '8'
                ],
                'label' => 'Description',
                "required" => false
            ])
            ->add('document', FileType::class, [
                'required' => false,
                'data_class' => Null,
                'label' => 'Document'
            ])
            ->add('enregistrer', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-sm btn-success'
                ],
                'label' => 'Mettre à jour'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Materieltype::class,
        ]);
    }
}
