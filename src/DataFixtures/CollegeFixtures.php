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
        'company' => 'company_Wild'
        ],
        ['name' => 'Collège B wild',
        'description' => 'Collège composé de 20 développeurs JS',
        'company' => 'company_Wild'
        ],
        ['name' => 'Collège A dephants',
        'description' => 'Collège composé de 10 développeurs',
        'company' => 'company_Dephants'
        ],
        ['name' => 'Collège A 404',
        'description' => 'Collège composé de 30 développeurs',
        'company' => 'company_Erreur404'
        ],
        ['name' => 'Collège B karma',
        'description' => 'Collège composé de 20 développeurs',
        'company' => 'company_Karma'
        ],
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::COLLEGES as $collegeName) {
            $college = new College();
            $college->setName($collegeName['name']);
            $college->setDescription($collegeName['description']);
            $college->setCompany($this->getReference($collegeName['company']));
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
