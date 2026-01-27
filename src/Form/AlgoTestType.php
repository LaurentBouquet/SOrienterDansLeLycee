<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;    
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AlgoTestType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('start', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'name',
                'choice_attr' => function(Location $location): array {
                    return [
                        'data-floor' => $location->getFloor(),
                        'data-type' => $location->getType(),
                    ];
                },
                'placeholder' => 'Sélectionner un lieu de départ',
            ])
            ->add('end', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'name',
                'choice_attr' => function(Location $location): array {
                    return [
                        'data-floor' => $location->getFloor(),
                        'data-type' => $location->getType(),
                    ];
                },
                'placeholder' => 'Sélectionner un lieu d\'arrivée',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here    
        ]);
    }
}
