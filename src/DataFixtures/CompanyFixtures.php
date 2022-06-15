<?php

namespace App\DataFixtures;

use App\Entity\Company;
use Doctrine\Persistence\ObjectManager;
use Doctrine\Bundle\FixturesBundle\Fixture;

class CompanyFixtures extends Fixture
{
    public const COMPANIES = [
        'Wild',
        'Dephants',
        'Erreur404',
        'Karma',
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::COMPANIES as $companyName) {
            $company = new Company();
            $company->setName($companyName);
            $manager->persist($company);
            $this->addReference('company_' . $companyName, $company);
        }

        $manager->flush();
    }
}
