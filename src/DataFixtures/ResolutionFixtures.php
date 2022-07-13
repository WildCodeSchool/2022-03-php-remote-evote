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
            'name' =>  'Choix du langage back',
            'description' => 'PHP est adopté.',
            'adoption_rule' => 'simple-majority',
            'campaign' => 'campaign_0'
        ],
        [
            'name' =>  'Choix du meilleur wilder du mois d\'Avril',
            'description' => 'Le meilleur wilder du mois a été choisi au 2/3.',
            'adoption_rule' => 'adoption-2/3',
            'campaign' => 'campaign_1'
        ],
        [
            'name' =>  'Choix du meilleur MasterCode',
            'description' => 'Le meilleur MasterCode a été choisi au 3/4.',
            'adoption_rule' => 'adoption-3/4',
            'campaign' => 'campaign_2'
        ],
        [
            'name' =>  'Choix de la meilleure équipe du Hackaton Apside',
            'description' => 'Le meilleure équipe a été choisie aux 3/4.',
            'adoption_rule' => 'adoption-3/4',
            'campaign' => 'campaign_3'
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
