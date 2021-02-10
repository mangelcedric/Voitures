<?php

namespace App\Form;

use App\Entity\Car;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;

class CarType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        
        $builder
            ->add('model', null, [
                'label' => 'Modèle :',
                'constraints' => [new Assert\NotBlank([
                    'message' => 'Le champs doit être rempli'
                ])],
            ])
            ->add('year', null, [
                'label' => 'Année du véhicule :',
                'constraints' => [new Assert\NotBlank([
                    'message' => 'Le champs doit être rempli'
                ]), new Assert\Range([
                    'min' => 1910,
                    'max' => date('Y') +1,
                ])],
            ])
            ->add('brand', null, [
                'label' => 'Marque :',
                'required' => true,
                'constraints' => [new Assert\NotBlank(),],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Car::class,
        ]);
    }
}
