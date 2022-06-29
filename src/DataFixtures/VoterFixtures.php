<?php

namespace App\DataFixtures;

use App\Entity\Campaign;
use App\Entity\Voter;
use Symfony\Component\Uid\Uuid;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class VoterFixtures extends Fixture implements DependentFixtureInterface
{
    public const VOTERS = [
        [
            'fullname' => 'Jean Richard', 'email' => 'jean33000@yopmail.com', 'campaign' => 'campaign_0',
            'number_vote' => 1
        ],
        [
            'fullname' => 'Michel Dupuis', 'email' => 'michel34000@yopmail.com', 'campaign' => 'campaign_1',
            'number_vote' => 2
        ],
    ];


    public function load(ObjectManager $manager): void
    {
        foreach (self::VOTERS as $key => $voterName) {
            $voter = new Voter();
            $voter->setUuid('4321' . $key);
            $voter->setFullname($voterName['fullname']);
            $voter->setEmail($voterName['email']);
            $voter->setNumberOfVote($voterName['number_vote']);
            $voter->setCampaign($this->getReference($voterName['campaign']));
            $manager->persist($voter);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CampaignFixtures::class,
        ];
    }
}
