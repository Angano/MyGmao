<?php

namespace App\Form;

use App\Entity\Intervention;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class JobType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('status', CheckboxType::class, [
                'attr' => [
                    'class' => "form-check-input",
                    'role' => "switch",
                ],
                'label' => 'Terminée',
                'label_attr' => ['class' => "form-check-label"],
                'required' => false
            ])
            ->add('travaux', TextareaType::class, [
                'attr' => [
                    'rows' => 10,
                ],
            ])
            ->add('compteur')
            ->add('dateIntervention', DateType::class, array(
                'widget' => 'single_text',
                'html5' => false,
                'label' => 'Date de demande (JJ/MM/AAAA)*',
                'format' => 'dd-MM-yyyy',
            ))
            ->add('enregistrer', SubmitType::class, ['attr' => ['class' => 'btn btn-sm btn-success']]);;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Intervention::class,
        ]);
    }
}
