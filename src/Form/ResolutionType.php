<?php

namespace App\Form;

use App\Entity\Campaign;
use App\Entity\Resolution;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

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
                'help' => 'Merci de rentrer une description, si nécessaire'
            ])
            ->add('adoption_rule', TextType::class, [
                'label' => 'Indiquez le nombre de voix requis pour l\'adoption de cette résolution',
                'help' => 'Merci d\'indiquer le nombre de voix requis'
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
