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
            'answer' => 'approved',
            'resolution' => 'resolution_0',
            'voter' => 'voter_4',
        ],
        [
            'answer' => 'approved',
            'resolution' => 'resolution_0',
            'voter' => 'voter_4',
        ],
        [
            'answer' => 'approved',
            'resolution' => 'resolution_0',
            'voter' => 'voter_5',
        ],
        [
            'answer' => 'approved',
            'resolution' => 'resolution_0',
            'voter' => 'voter_8',
        ],
        [
            'answer' => 'rejected',
            'resolution' => 'resolution_0',
            'voter' => 'voter_6',
        ],
        [
            'answer' => 'rejected',
            'resolution' => 'resolution_0',
            'voter' => 'voter_1',
        ],
        [
            'answer' => 'abstention',
            'resolution' => 'resolution_0',
            'voter' => 'voter_2',
        ],
        [
            'answer' => 'abstention',
            'resolution' => 'resolution_0',
            'voter' => 'voter_3',
        ],
        [
            'answer' => 'abstention',
            'resolution' => 'resolution_0',
            'voter' => 'voter_7',
        ],
        [
            'answer' => 'rejected',
            'resolution' => 'resolution_0',
            'voter' => 'voter_9',
        ],
        [
            'answer' => 'rejected',
            'resolution' => 'resolution_0',
            'voter' => 'voter_10',
        ],
        [
            'answer' => 'abstention',
            'resolution' => 'resolution_0',
            'voter' => 'voter_11',
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
