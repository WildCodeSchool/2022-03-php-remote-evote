<?php

namespace App\Form;

use App\Entity\Voter;
use App\Entity\College;
use App\Entity\ProxyFor;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;

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
            ->add('company', TextType::class, [
                'label' => 'Si oui, dénomination de la structure qu\'il représente',
                'attr' => array(
                    'placeholder' => 'Test'
                ),
                'required' => false,
                'mapped' => false
            ])
            ->add('college', ChoiceType::class, [
                'choice_value' => 'name',
                'choice_label' => function (?College $college) {
                    return $college ? strtoupper($college->getName()) : '';
                },
                'label' => 'Collèges d\'appartenance (optionnel)',
                'attr' => array(
                    'placeholder' => 'Test'
                )
            ])
            ->add('email', EmailType::class, [
                'label' => 'Mél du votant',
                'attr' => array(
                    'placeholder' => 'email@test.com'
                )
            ])
            ->add('telephone', TelType::class, [
                'label' => 'Tél du votant',
                'attr' => array(
                    'placeholder' => '0600000000'
                )
            ])
            ->add('numberOfVote', IntegerType::class, [
                'label' => 'Nombre de voix',
                'attr' => array(
                    'placeholder' => 1
                )
            ])
            // ->add('proxyFor', EntityType::class, [
            //     'class' => ProxyFor::class,
            //     'label' => 'Vous avez déclaré plus d\'une voie, nom de la personne que vous representez',
            //     'choice_label' => 'name',
            //     'attr' => array(
            //         'placeholder' => 'Michel SAPIN'
            //     ),
            //     'required' => false,
            //     'mapped' => false
            // ])
            ->add('proxyFor', CollectionType::class, [
                'entry_type' => ProxyVoterType::class,
                'label' => false,
                'by_reference' => false,
                'allow_add' => true,
                'allow_delete' => true
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
