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
        ['name' =>  'Approbation des comptes 2022',
        'description' => 'Le résultat est positif. Le bilan progresse',
        'adoption_rule' => 'Majorité simple',
        'campaign' => 'campaign_1'
        ]
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::RESOLUTION as $resolutionName) {
            $uuid = Uuid::v4();
            $resolution = new Resolution();
            $resolution->setUuid($uuid->toRfc4122());
            $resolution->setName($resolutionName['name']);
            $resolution->setDescription($resolutionName['description']);
            $resolution->setAdoptionRule($resolutionName['adoption_rule']);
            $resolution->setCampaign($this->getReference($resolutionName['campaign']));
            $manager->persist($resolution);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [(CampaignFixtures::class)];
    }
}
