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
                'attr' => array(
                    'placeholder' => 'Approbation des comptes 2022'
                )
            ])
            ->add('description', TextType::class, [
                'label' => 'Description (optionnel)',
                'attr' => array(
                    'placeholder' => 'Le résultat est positif. Le bilan progresse.'
                )
            ])
            ->add('adoption_rule', TextType::class, [
                'label' => 'Indiquez le nombre de voix requis pour l\'adoption de cette résolution',
                'attr' => array(
                    'placeholder' => 'Majorité simple, majorité des 2/3, majorité des 3/4'
                )
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
