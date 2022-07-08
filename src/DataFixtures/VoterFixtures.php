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
            'fullname' => 'Jean Richard',
            'email' => 'jean33000@yopmail.com',
            'campaign' => 'campaign_0',
            'number_vote' => 1,
            'college' => 'college_0',
            'votePercentage' => 50,
        ],
        [
            'fullname' => 'Michael Dupont',
            'email' => 'michael34000@yopmail.com',
            'campaign' => 'campaign_1',
            'number_vote' => 1,
            'college' => 'college_1',
            'votePercentage' => 15,
        ],
        [
            'fullname' => 'Michel Dupuis',
            'email' => 'michel34000@yopmail.com',
            'campaign' => 'campaign_2',
            'number_vote' => 1,
            'college' => 'college_2',
            'votePercentage' => 25,
        ],
        [
            'fullname' => 'Fred Shortman',
            'email' => 'fred34000@yopmail.com',
            'campaign' => 'campaign_3',
            'number_vote' => 1,
            'college' => 'college_3',
            'votePercentage' => 45,
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
            $voter->setVotePercentage($voterName['votePercentage']);
            $voter->setCampaign($this->getReference($voterName['campaign']));
            $voter->setCollege($this->getReference($voterName['college']));
            $this->addReference('voter_' . $key, $voter);
            $manager->persist($voter);
        }
        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            CampaignFixtures::class,
            CollegeFixtures::class,
        ];
    }
}
