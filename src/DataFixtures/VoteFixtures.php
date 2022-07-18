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
        //campaign_0->byColleges
        [
            'answer' => 'approved',
            'resolution' => 'resolution_0',
            'voter' => 'voter_0',
        ],
        [
            'answer' => 'approved',
            'resolution' => 'resolution_0',
            'voter' => 'voter_1',
        ],
        [
            'answer' => 'approved',
            'resolution' => 'resolution_0',
            'voter' => 'voter_2',
        ],
        [
            'answer' => 'approved',
            'resolution' => 'resolution_0',
            'voter' => 'voter_3',
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
            'voter' => 'voter_6',
        ],
        [
            'answer' => 'rejected',
            'resolution' => 'resolution_0',
            'voter' => 'voter_7',
        ],
        [
            'answer' => 'rejected',
            'resolution' => 'resolution_0',
            'voter' => 'voter_8',
        ],
        [
            'answer' => 'abstention',
            'resolution' => 'resolution_0',
            'voter' => 'voter_9',
        ],
        [
            'answer' => 'rejected',
            'resolution' => 'resolution_0',
            'voter' => 'voter_10',
        ],
        [
            'answer' => 'rejected',
            'resolution' => 'resolution_0',
            'voter' => 'voter_11',
        ],
        [
            'answer' => 'abstention',
            'resolution' => 'resolution_0',
            'voter' => 'voter_12',
        ],
        [
            'answer' => 'abstention',
            'resolution' => 'resolution_0',
            'voter' => 'voter_13',
        ],
        [
            'answer' => 'abstention',
            'resolution' => 'resolution_0',
            'voter' => 'voter_14',
        ],
        //campaign_1->byvoters
        [
            'answer' => 'approved',
            'resolution' => 'resolution_1',
            'voter' => 'voter_15',
        ],
        [
            'answer' => 'approved',
            'resolution' => 'resolution_1',
            'voter' => 'voter_16',
        ],
        [
            'answer' => 'approved',
            'resolution' => 'resolution_1',
            'voter' => 'voter_17',
        ],
        [
            'answer' => 'approved',
            'resolution' => 'resolution_1',
            'voter' => 'voter_18',
        ],
        [
            'answer' => 'approved',
            'resolution' => 'resolution_1',
            'voter' => 'voter_19',
        ],
        [
            'answer' => 'approved',
            'resolution' => 'resolution_1',
            'voter' => 'voter_20',
        ],
        [
            'answer' => 'approved',
            'resolution' => 'resolution_1',
            'voter' => 'voter_21',
        ],
        [
            'answer' => 'rejected',
            'resolution' => 'resolution_1',
            'voter' => 'voter_22',
        ],
        [
            'answer' => 'rejected',
            'resolution' => 'resolution_1',
            'voter' => 'voter_23',
        ],
        [
            'answer' => 'rejected',
            'resolution' => 'resolution_1',
            'voter' => 'voter_24',
        ],
        [
            'answer' => 'rejected',
            'resolution' => 'resolution_1',
            'voter' => 'voter_25',
        ],
        [
            'answer' => 'abstention',
            'resolution' => 'resolution_1',
            'voter' => 'voter_26',
        ],
        [
            'answer' => 'abstention',
            'resolution' => 'resolution_1',
            'voter' => 'voter_27',
        ],
        [
            'answer' => 'abstention',
            'resolution' => 'resolution_1',
            'voter' => 'voter_28',
        ],
        [
            'answer' => 'approved',
            'resolution' => 'resolution_1',
            'voter' => 'voter_29',
        ],
        [
            'answer' => 'approved',
            'resolution' => 'resolution_1',
            'voter' => 'voter_30',
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
