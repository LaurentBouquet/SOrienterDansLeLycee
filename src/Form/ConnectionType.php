<?php

namespace App\Form;

use App\Entity\Connection;
use App\Entity\Location;
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
            ->add('weight', ChoiceType::class, [
                'choices' => [
                    'Marche' => 5,
                    'Ascenseur' => 7,
                    'Escalier' => 10,
                ],
            ])
            ->add('pmr')
            ->add('instructionAtoB')
            ->add('instructionBtoA')
            ->add('locationA', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'name',
            ])
            ->add('locationB', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'name',
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
