<?php

namespace App\Form;

use App\Entity\College;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\PercentType;

class CollegeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
        ->add('name', TextType::class, [
            'label' => 'Nom du collège',
            'help' => 'Merci de rentrer le nom du collège (vous pouvez mettre une lettre ou un numéro aussi)'
        ])
        ->add('description', TextType::class, [
            'label' => 'Description (optionnel)',
            'required' => false,
            'help' => 'Merci de rentrer une description, si nécessaire'
        ])
        ->add('vote_percentage', PercentType::class, [
            'label' => 'Indiquez le nombre de voix représentées par ce collège (%)',
            'scale' => 2,
            'help' => 'Merci d\'indiquer votre choix'
        ])
    ;
}

public function configureOptions(OptionsResolver $resolver): void
{
    $resolver->setDefaults([
        'data_class' => College::class,
    ]);
}
}
