<?php

namespace App\DataFixtures;

use Faker\Factory;
use App\Entity\Resolution;
use Symfony\Component\Uid\Uuid;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class ResolutionFixtures extends Fixture implements DependentFixtureInterface
{
    public const RESOLUTION = [
        [
            'name' =>  'Approbation des comptes 2022',
            'description' => 'Le résultat est positif. Le bilan progresse.',
            'adoption_rule' => 'simple-majority',
            'campaign' => 'campaign_0'
        ],
        [
            'name' =>  'Rémunération du gérant',
            'description' => 'Le gérant sera rémunéré 10€ cette année.',
            'adoption_rule' => 'adoption-2/3',
            'campaign' => 'campaign_0'
        ],
        [
            'name' =>  'Budget 2022',
            'description' => 'Le budget 2022 est de 1.5 M€ avec une rémunération des actionnaires de
        500.000 €.',
            'adoption_rule' => 'adoption-3/4',
            'campaign' => 'campaign_1'
        ],
        [
            'name' =>  'Quitus au dirigeant pour l\'exercice écoulé',
            'description' => 'Le niveau de gestion du dirigeant est approuvé.',
            'adoption_rule' => 'adoption-2/3',
            'campaign' => 'campaign_1'
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::RESOLUTION as $key => $resolutionName) {
            $uuid = Uuid::v4();
            $resolution = new Resolution();
            $resolution->setUuid($uuid->toRfc4122());
            $resolution->setName($resolutionName['name']);
            $resolution->setDescription($resolutionName['description']);
            $resolution->setAdoptionRule($resolutionName['adoption_rule']);
            $resolution->setCampaign($this->getReference($resolutionName['campaign']));
            $this->addReference('resolution_' . $key, $resolution);
            $manager->persist($resolution);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [(CampaignFixtures::class)];
    }
}
