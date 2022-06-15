<?php

namespace App\Form;

use App\Entity\Voter;
use App\Entity\College;
use App\Entity\Company;
use App\Entity\ProxyFor;
use App\Repository\CollegeRepository;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;

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
                'label' => 'Dénomination de la structure qu\'il représente',
                'attr' => array(
                    'placeholder' => 'Test'
                ),
                'required' => false,
                'mapped' => false
            ])

            // ->add('college', null, ['choice_label' => 'name'])

            // ->add('college', ChoiceType::class, [
            //     'choice_value' => 'name',
            //     'choice_label' => function (?College $college) {
            //         return $college ? strtoupper($college->getName()) : '';
            //     },
            //     'label' => 'Collèges d\'appartenance (optionnel)',
            //     'attr' => array(
            //         'placeholder' => 'Test'
            //     )
            // ])

            // ->add('college', EntityType::class, [
            //     'required' => false,
            //     'class' => College::class,
            //     'choice_label' => 'name',
            //     'choices' => function () {
            //         //lister les collèges de la compagnie associée à la campagne de vote
            //         //faire une requête personnalisée du type SELECT * FROM college WHERE campaign_id = campaign.id
            //     },
            //     ,
            //     'placeholder' => 'Sélectionnez un collège',
            // ])
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
