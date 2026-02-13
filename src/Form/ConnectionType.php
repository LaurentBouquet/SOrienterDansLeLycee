<?php

namespace App\Form;

use App\Entity\Location;
use App\Entity\Connection;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ConnectionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            /* 
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
                */
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
                'label' => 'Lieu de départ :',
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
                'label' => 'Lieu d\'arrivée :',
            ])
            ->add('pmr', CheckboxType::class, [
                'required' => false,
                'label' => 'Accessible PMR :',
            ])
            ->add('instructionAtoB', null, [
                'required' => false,
                'label' => 'Instructions de A vers B :',
            ])
            ->add('instructionBtoA', null, [
                'required' => false,
                'label' => 'Instructions de B vers A :',
            ])
            ->add('weight', ChoiceType::class, [
                'choices' => [
                    'Marche' => 5,
                    'Ascenseur' => 7,
                    'Escalier' => 10,
                ],
                'placeholder' => 'Sélectionner un type de connexion',
                'label' => 'Type de connexion :',
            ])
            ->add('imageAtoB', FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '4000k',
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger une image valide',
                    ])
                ],
            ])
            ->add('imageBtoA', FileType::class, [
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '4000k',
                        'mimeTypes' => [
                            'image/*',
                        ],
                        'mimeTypesMessage' => 'Veuillez télécharger une image valide',
                    ])
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Connection::class,
        ]);
    }
}
