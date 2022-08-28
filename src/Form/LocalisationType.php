<?php

namespace App\Form;

use App\Entity\Site;
use App\Entity\Equipement;
use App\Entity\Localisation;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class LocalisationType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('equipement', EntityType::class, [
                'class'  => Equipement::class,
                'choice_label' => 'name'
            ])
            ->add('site', EntityType::class, [
                'class'  => Site::class,
                'choice_label' => 'name'
            ])
            
            ->add('usedAt', DateType::class, [
                'widget' => 'choice',
                'input'  => 'datetime',
                'format' => 'dd MMMM yyyy'
            ])
            ->add('state',ChoiceType::class, [
                'choices'  => [
                    'En service'=>'En service',
                    'En panne'=>'En panne',
                    'Hors service' => 'Hors service'
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Localisation::class,
        ]);
    }
}
