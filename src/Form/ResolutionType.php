<?php

namespace App\Form;

use App\Entity\Campaign;
use App\Entity\Resolution;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class ResolutionType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de la résolution telle qu\'elle figure à l\'ordre du jour',
                'help' => 'Merci de rentrer le nom de la résolution'
            ])
            ->add('description', TextType::class, [
                'label' => 'Description (optionnel)',
                'required' => false,
                'help' => 'Merci de rentrer une description, si nécessaire'
            ])
            ->add('adoption_rule', ChoiceType::class, [
                'choices' => [
                    'Majorité simple' => 'simple-majority',
                    'Adoption aux 2/3' => 'adoption-2/3',
                    'Adoption aux 3/4' => 'adoption-3/4',
                ],
                'label' => 'Indiquez le nombre de voix requis pour l\'adoption de cette résolution',
                'help' => 'Merci d\'indiquer votre choix'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Resolution::class,
        ]);
    }
}
