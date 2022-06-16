<?php

namespace App\DataFixtures;

use App\Entity\Campaign;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CampaignFixtures extends Fixture implements DependentFixtureInterface
{
    public const CAMPAIGNS = [
        ['name' => 'Le meilleur langage back',
        'description' => 'Campagne de vote pour élire le meilleur langage de tous les temps',
        'has_college' => true,
        'company' => 'company_Wild'
        ],
        ['name' => 'Wilder du mois',
        'description' => 'Campagne de vote pour élire le wilder du mois',
        'has_college' => false,
        'company' => 'company_Dephants'
        ]
    ];


    public function load(ObjectManager $manager): void
    {
        foreach (self::CAMPAIGNS as $key => $campaignName) {
            $campaign = new Campaign();
            $campaign->setName($campaignName['name']);
            $campaign->setUuid('1234' . $key);
            $campaign->setDescription($campaignName['description']);
            $campaign->setHasCollege($campaignName['has_college']);
            $campaign->setCompany($this->getReference($campaignName['company']));
            $manager->persist($campaign);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        // Tu retournes ici toutes les classes de fixtures dont ProgramFixtures dépend
        return [
        CompanyFixtures::class,
        ];
    }
}
