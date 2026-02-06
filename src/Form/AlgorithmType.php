<?php

namespace App\Form;

use App\Entity\Location;
use Doctrine\ORM\QueryBuilder;
use Doctrine\ORM\EntityRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class AlgorithmType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('start', EntityType::class, [
                'class' => Location::class,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('loc')
                        ->where("loc.type = 'ROOM'");
                },
                'choice_label' => 'name',
                'choice_attr' => function (Location $location): array {
                    return [
                        'data-floor' => $location->getFloor(),
                        'data-type' => $location->getType(),
                    ];
                },
                'placeholder' => 'Sélectionner un lieu de départ',
            ])
            ->add('end', EntityType::class, [
                'class' => Location::class,
                'query_builder' => function (EntityRepository $er): QueryBuilder {
                    return $er->createQueryBuilder('loc')
                        ->where("loc.type = 'ROOM'");
                },
                'choice_label' => 'name',
                'choice_attr' => function (Location $location): array {
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
