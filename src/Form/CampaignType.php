<?php

namespace App\Form;

use App\Entity\Campaign;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class CampaignType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'label' => 'Nom de votre campagne de vote',
                'attr' => array(
                    'placeholder' => 'Test'
                )
            ])
            ->add('company', TextType::class, [
                'label' => 'Structure concernée (optionnel)',
                'attr' => array(
                    'placeholder' => 'NOBATEK'
                ),
                'required' => false,
                'mapped' => false
            ])
            ->add('description', TextType::class, [
                'label' => 'Description de votre campagne de vote',
                'attr' => array(
                    'placeholder' => 'Voici le détail de cette campagne de vote'
                )
            ])
            ->add('hasCollege', CheckboxType::class, [
                'label' => 'Ce vote intègre des collèges',
                'required' => false
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Campaign::class,
        ]);
    }
}
