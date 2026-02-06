<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\Connection;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ConnectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('pmr')
            ->add('floorA', ChoiceType::class, [
                'choices' => [
                    'Sous-sol' => -1,
                    'RDC' => 0,
                    '1er étage' => 1,
                    '2e étage' => 2,
                    '3e étage' => 3,
                ],
                'mapped' => false,
                'required' => false,
                // 'expanded' => true,
                // 'multiple' => false, // Mettre à true pour des cases à cocher 
            ])
            ->add('floorB', ChoiceType::class, [
                'choices' => [
                    'Sous-sol' => -1,
                    'RDC' => 0,
                    '1er étage' => 1,
                    '2e étage' => 2,
                    '3e étage' => 3,
                ],
                'mapped' => false,
                'required' => false,
                // 'expanded' => true,
                // 'multiple' => false, // Mettre à true pour des cases à cocher 
            ])
            ->add('locationA', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'name',
                'choice_attr' => function (Location $location): array {
                    return [
                        'data-floor' => $location->getFloor(),
                        'data-type' => $location->getType(),
                    ];
                },
                'placeholder' => 'Sélectionner un lieu de départ',
            ])
            ->add('locationB', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'name',
                'choice_attr' => function (Location $location): array {
                    return [
                        'data-floor' => $location->getFloor(),
                        'data-type' => $location->getType(),
                    ];
                },
                'placeholder' => 'Sélectionner un lieu d\'arrivée',
            ])
            ->add('instructionAtoB')
            ->add('instructionBtoA')
            ->add('weight', ChoiceType::class, [
                'choices' => [
                    'Marche' => 5,
                    'Ascenseur' => 7,
                    'Escalier' => 10,
                ],
                'placeholder' => 'Sélectionner un type de connexion',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Connection::class,
        ]);
    }
}