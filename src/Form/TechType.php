<?php

namespace App\Form;

use App\Entity\Tech;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class TechType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('avatar')
            ->add('firstname')
            ->add('lastname')
            ->add('speciality')
            ->add('address')
            ->add('contact')
            ->add('email')
            ->add('hash')
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Tech::class,
        ]);
    }
}
