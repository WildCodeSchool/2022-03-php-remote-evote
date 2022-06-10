<?php

namespace App\Form;

use App\Entity\Voter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class VoterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('fullname', TextType::class, [
                'label' => 'Nom du votant',
                'attr' => array(
                    'placeholder' => 'Test'
                )
            ])
            ->add('email', EmailType::class, [
                'label' => 'Mél du votant',
                'attr' => array(
                    'placeholder' => 'Test'
                )
            ])
            ->add('telephone', TelType::class, [
                'label' => 'Tél du votant',
                'attr' => array(
                    'placeholder' => 'Test'
                )
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Voter::class,
        ]);
    }
}
