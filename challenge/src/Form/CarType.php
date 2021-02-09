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
        // $minimumYear = 1910;
        // $maximumYear = (int) (new \DateTime('+1 year'))->format('Y');
        // $maximumYear = date('Y', strtotime('+ 1 year'));
        // $maximumYear = date('Y') + 1;

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
                    'min' => 1910, // ou $miniYear
                    'max' => date('Y') +1, // ou $maximumYear
                    // 'max' => (new \DateTime('+1 year'))->format('Y'),
                    //'minMessage' => 'Votre voiture doit être immatriculée au moins depuis {{ value }}',
                    //'maxMessage' => 'Votre voiture doit être immatriculée au maximum en {{ value }}'
                ])],
            ])
            ->add('brand', null, [
                // Avec un entity type, pour afficher le SELECT sans erreur il faut,
                // au choix, créer la fonction __toString() dans l'entité ou 
                // préciser le champs qu'on souhaite afficher
                // Si on veut un format particulier,
                // c'est-à-dore ni celui défini dans le __toString() ni le name seul
                // on peut indiquer dans choice_label, par exemple, displayName et créer un getDisplayName() dans l'entité
                // 'choice_label' => 'name',
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
