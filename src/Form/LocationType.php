<?php

namespace App\Form;

use App\Entity\Location;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;

class LocationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'required' => true,
            ])
            ->add('floor', ChoiceType::class, [
                'required' => true,
                'choices' => [
                    'Sous-sol' => -1,
                    'Rez-de-chaussée' => 0,
                    'Premier étage' => 1,
                    'Deuxième étage' => 2,
                    'Troisième étage' => 3,
                ],
            ])
            ->add('type', ChoiceType::class, [
                'required' => true,
                'choices' => [
                    'Salle' => 'ROOM',
                    'Couloir' => 'CORRIDOR',
                    'Escalier' => 'STAIRS',
                    'Ascenseur' => 'ELEVATOR',
                    'Entrée/Sortie' => 'ENTRANCE_EXIT',
                ],
            ])
            ->add('reference', TextType::class, [
                'required' => false,
            ])
            ->add('imageA', FileType::class, [
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
            'data_class' => Location::class,
        ]);
    }
}
