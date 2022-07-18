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
            'telephone' => '0123456789',
            'company' => 'company_Wild'
        ],
        [
            'fullname' => 'Michael Dupont',
            'email' => 'michael34000@yopmail.com',
            'campaign' => 'campaign_0',
            'number_vote' => 1,
            'college' => 'college_0',
            'votePercentage' => 15,
            'telephone' => '0123456789',
            'company' => 'company_Dephants'
        ],
        [
            'fullname' => 'Michel Dupuis',
            'email' => 'michel34000@yopmail.com',
            'campaign' => 'campaign_0',
            'number_vote' => 1,
            'college' => 'college_0',
            'votePercentage' => 25,
            'telephone' => '0123456789',
            'company' => 'company_Erreur404'
        ],
        [
            'fullname' => 'Fred Shortman',
            'email' => 'fred34000@yopmail.com',
            'campaign' => 'campaign_0',
            'number_vote' => 1,
            'college' => 'college_0',
            'votePercentage' => 45,
            'telephone' => '0123456789',
            'company' => 'company_Wild'
        ],
        [
            'fullname' => 'Amelia Melyss',
            'email' => 'amelia34000@yopmail.com',
            'campaign' => 'campaign_0',
            'number_vote' => 1,
            'college' => 'college_0',
            'votePercentage' => 45,
            'telephone' => '0123456789',
            'company' => 'company_Wild'
        ],
        [
            'fullname' => 'Archess Ney',
            'email' => 'ney34000@yopmail.com',
            'campaign' => 'campaign_0',
            'number_vote' => 1,
            'college' => 'college_0',
            'votePercentage' => 45,
            'telephone' => '0123456789',
            'company' => 'company_Wild'
        ],
        [
            'fullname' => 'Mikasa Hackermann',
            'email' => 'hackermann@yopmail.com',
            'campaign' => 'campaign_0',
            'number_vote' => 1,
            'college' => 'college_0',
            'votePercentage' => 45,
            'telephone' => '0123456789',
            'company' => 'company_Wild'
        ],
        [
            'fullname' => 'Tanjiro Kamado',
            'email' => 'kamado@yopmail.com',
            'campaign' => 'campaign_0',
            'number_vote' => 1,
            'college' => 'college_0',
            'votePercentage' => 45,
            'telephone' => '0123456789',
            'company' => 'company_Wild'
        ],
        [
            'fullname' => 'Asyra Chan',
            'email' => 'asyra@yopmail.com',
            'campaign' => 'campaign_0',
            'number_vote' => 1,
            'college' => 'college_0',
            'votePercentage' => 45,
            'telephone' => '0123456789',
            'company' => 'company_Wild'
        ],
        [
            'fullname' => 'Aloe Vera',
            'email' => 'vera@yopmail.com',
            'campaign' => 'campaign_0',
            'number_vote' => 1,
            'college' => 'college_0',
            'votePercentage' => 45,
            'telephone' => '0123456789',
            'company' => 'company_Wild'
        ],
        [
            'fullname' => 'Verny Sage',
            'email' => 'sage@yopmail.com',
            'campaign' => 'campaign_0',
            'number_vote' => 1,
            'college' => 'college_0',
            'votePercentage' => 45,
            'telephone' => '0123456789',
            'company' => 'company_Wild'
        ],
        [
            'fullname' => 'Amy Wang',
            'email' => 'wang@yopmail.com',
            'campaign' => 'campaign_0',
            'number_vote' => 1,
            'college' => 'college_0',
            'votePercentage' => 45,
            'telephone' => '0123456789',
            'company' => 'company_Wild'
        ],
        [
            'fullname' => 'Solomon Burke',
            'email' => 'burke@yopmail.com',
            'campaign' => 'campaign_0',
            'number_vote' => 1,
            'college' => 'college_0',
            'votePercentage' => 45,
            'telephone' => '0123456789',
            'company' => 'company_Wild'
        ],
        [
            'fullname' => 'Otis Redding',
            'email' => 'redding@yopmail.com',
            'campaign' => 'campaign_0',
            'number_vote' => 1,
            'college' => 'college_0',
            'votePercentage' => 45,
            'telephone' => '0123456789',
            'company' => 'company_Wild'
        ],
        [
            'fullname' => 'Aretha Franklin',
            'email' => 'franklin@yopmail.com',
            'campaign' => 'campaign_0',
            'number_vote' => 1,
            'college' => 'college_0',
            'votePercentage' => 45,
            'telephone' => '0123456789',
            'company' => 'company_Wild'
        ],
        [
            'fullname' => 'Ella Fitzgerald',
            'email' => 'fitzgerald@yopmail.com',
            'campaign' => 'campaign_0',
            'number_vote' => 1,
            'college' => 'college_1',
            'votePercentage' => 45,
            'telephone' => '0123456789',
            'company' => 'company_Wild'
        ],
        [
            'fullname' => 'Diana Ross',
            'email' => 'ross@yopmail.com',
            'campaign' => 'campaign_0',
            'number_vote' => 1,
            'college' => 'college_1',
            'votePercentage' => 45,
            'telephone' => '0123456789',
            'company' => 'company_Wild'
        ],
        [
            'fullname' => 'Wilson Pickett',
            'email' => 'pickett@yopmail.com',
            'campaign' => 'campaign_0',
            'number_vote' => 1,
            'college' => 'college_1',
            'votePercentage' => 45,
            'telephone' => '0123456789',
            'company' => 'company_Wild'
        ],
        [
            'fullname' => 'Sam Cooks',
            'email' => 'cooks@yopmail.com',
            'campaign' => 'campaign_0',
            'number_vote' => 1,
            'college' => 'college_1',
            'votePercentage' => 45,
            'telephone' => '0123456789',
            'company' => 'company_Wild'
        ],
        [
            'fullname' => 'Etta James',
            'email' => 'james@yopmail.com',
            'campaign' => 'campaign_0',
            'number_vote' => 1,
            'college' => 'college_1',
            'votePercentage' => 45,
            'telephone' => '0123456789',
            'company' => 'company_Wild'
        ],
        [
            'fullname' => 'The Staples Singers',
            'email' => 'staples@yopmail.com',
            'campaign' => 'campaign_0',
            'number_vote' => 1,
            'college' => 'college_1',
            'votePercentage' => 45,
            'telephone' => '0123456789',
            'company' => 'company_Wild'
        ],
        [
            'fullname' => 'Jimi Hendrix',
            'email' => 'hendrix@yopmail.com',
            'campaign' => 'campaign_0',
            'number_vote' => 1,
            'college' => 'college_1',
            'votePercentage' => 45,
            'telephone' => '0123456789',
            'company' => 'company_Wild'
        ],
        [
            'fullname' => 'Janis Joplin',
            'email' => 'joplin@yopmail.com',
            'campaign' => 'campaign_0',
            'number_vote' => 1,
            'college' => 'college_1',
            'votePercentage' => 45,
            'telephone' => '0123456789',
            'company' => 'company_Wild'
        ],
        [
            'fullname' => 'Jim Morrison',
            'email' => 'morrison@yopmail.com',
            'campaign' => 'campaign_0',
            'number_vote' => 1,
            'college' => 'college_1',
            'votePercentage' => 45,
            'telephone' => '0123456789',
            'company' => 'company_Wild'
        ],
        [
            'fullname' => 'The Doors',
            'email' => 'the_doors@yopmail.com',
            'campaign' => 'campaign_0',
            'number_vote' => 1,
            'college' => 'college_1',
            'votePercentage' => 45,
            'telephone' => '0123456789',
            'company' => 'company_Wild'
        ],
        [
            'fullname' => 'Syd Barrett',
            'email' => 'barrett@yopmail.com',
            'campaign' => 'campaign_0',
            'number_vote' => 1,
            'college' => 'college_1',
            'votePercentage' => 45,
            'telephone' => '0123456789',
            'company' => 'company_Wild'
        ],
        [
            'fullname' => 'Cream',
            'email' => 'cream@yopmail.com',
            'campaign' => 'campaign_0',
            'number_vote' => 1,
            'college' => 'college_1',
            'votePercentage' => 45,
            'telephone' => '0123456789',
            'company' => 'company_Wild'
        ],
        [
            'fullname' => 'Canned Heat',
            'email' => 'heat@yopmail.com',
            'campaign' => 'campaign_0',
            'number_vote' => 1,
            'college' => 'college_1',
            'votePercentage' => 45,
            'telephone' => '0123456789',
            'company' => 'company_Wild'
        ],
        [
            'fullname' => 'John Lennon',
            'email' => 'lennon@yopmail.com',
            'campaign' => 'campaign_0',
            'number_vote' => 1,
            'college' => 'college_1',
            'votePercentage' => 45,
            'telephone' => '0123456789',
            'company' => 'company_Wild'
        ],
        [
            'fullname' => 'The Beatles',
            'email' => 'the_beatles@yopmail.com',
            'campaign' => 'campaign_0',
            'number_vote' => 1,
            'college' => 'college_1',
            'votePercentage' => 45,
            'telephone' => '0123456789',
            'company' => 'company_Wild'
        ],
        [
            'fullname' => 'Paul McCartney',
            'email' => 'cartney@yopmail.com',
            'campaign' => 'campaign_0',
            'number_vote' => 1,
            'college' => 'college_1',
            'votePercentage' => 45,
            'telephone' => '0123456789',
            'company' => 'company_Karma'
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::VOTERS as $key => $voterName) {
            $voter = new Voter();
            $voter->setUuid('4321' . $key);
            $voter->setFullname($voterName['fullname']);
            $voter->setTelephone($voterName['telephone']);
            $voter->setEmail($voterName['email']);
            $voter->setNumberOfVote($voterName['number_vote']);
            $voter->setVotePercentage($voterName['votePercentage']);
            $voter->setCampaign($this->getReference($voterName['campaign']));
            $voter->setCompany($this->getReference($voterName['company']));
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
            CompanyFixtures::class,
        ];
    }
}
