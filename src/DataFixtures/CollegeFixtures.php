<?php

namespace App\DataFixtures;

use App\Entity\College;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;

class CollegeFixtures extends Fixture implements DependentFixtureInterface
{
    public const COLLEGES = [
        ['name' => 'Collège A wild',
        'description' => 'Collège composé de 10 développeurs PHP',
        'vote_percentage' => 0.5,
        'company' => 'company_Wild'
        ],
        ['name' => 'Collège B wild',
        'description' => 'Collège composé de 20 développeurs JS',
        'vote_percentage' => 0.2,
        'company' => 'company_Wild'
        ],
        ['name' => 'Collège A dephants',
        'description' => 'Collège composé de 10 développeurs',
        'vote_percentage' => 0.1,
        'company' => 'company_Dephants'
        ],
        ['name' => 'Collège B dephants',
        'description' => 'Collège composé de 21 développeurs',
        'vote_percentage' => 0.1,
        'company' => 'company_Dephants'
        ],
        ['name' => 'Collège A 404',
        'description' => 'Collège composé de 30 développeurs',
        'vote_percentage' => 0.3,
        'company' => 'company_Erreur404'
        ],
        ['name' => 'Collège B 404',
        'description' => 'Collège composé de 15 développeurs',
        'vote_percentage' => 0.3,
        'company' => 'company_Erreur404'
        ],
        ['name' => 'Collège A karma',
        'description' => 'Collège composé de 10 développeurs',
        'vote_percentage' => 0.4,
        'company' => 'company_Karma'
        ],
        ['name' => 'Collège B karma',
        'description' => 'Collège composé de 20 développeurs',
        'vote_percentage' => 0.4,
        'company' => 'company_Karma'
        ],
        ['name' => 'Collège C karma',
        'description' => 'Collège composé de 20 développeurs',
        'vote_percentage' => 0.2,
        'company' => 'company_Karma'
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::COLLEGES as $key => $collegeName) {
            $college = new College();
            $college->setName($collegeName['name']);
            $college->setDescription($collegeName['description']);
            $college->setVotePercentage($collegeName['vote_percentage']);
            $college->setCompany($this->getReference($collegeName['company']));
            $this->addReference('college_' . $key, $college);
            $manager->persist($college);
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
