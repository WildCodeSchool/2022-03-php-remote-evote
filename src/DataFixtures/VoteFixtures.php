<?php

namespace App\DataFixtures;

use Doctrine\Persistence\ObjectManager;
use App\DataFixtures\ResolutionFixtures;
use App\Entity\Vote;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class VoteFixtures extends Fixture implements DependentFixtureInterface
{
    public const VOTES = [
        [
            'answer' => 'approved',
            'resolution' => 'resolution_0',
            'voter' => 'voter_0',
        ],
        [
            'answer' => 'rejected',
            'resolution' => 'resolution_1',
            'voter' => 'voter_1',
        ],
        [
            'answer' => 'abstention',
            'resolution' => 'resolution_2',
            'voter' => 'voter_2',
        ],
        [
            'answer' => 'approved',
            'resolution' => 'resolution_3',
            'voter' => 'voter_3',
        ],

    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::VOTES as $voteName) {
            $vote = new Vote();
            $vote->setAnswer($voteName['answer']);
            $vote->setResolution($this->getReference($voteName['resolution']));
            $vote->setVoter($this->getReference($voteName['voter']));
            $manager->persist($vote);
        }

        $manager->flush();
    }

    public function getDependencies()
    {
        return [
            ResolutionFixtures::class,
            VoterFixtures::class,
        ];
    }
}
