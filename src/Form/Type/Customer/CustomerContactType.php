<?php

namespace App\Form\Type\Customer;

use App\Entity\CustomerContact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CustomerContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class)
            ->add('lastName', TextType::class)
            ->add('phone', TextType::class)
            ->add('jobTitle', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CustomerContact::class
        ]);
    }

    public function getBlockPrefix(): string
    {
        return '';
    }

    public function getName(): string
    {
        return '';
    }
}
