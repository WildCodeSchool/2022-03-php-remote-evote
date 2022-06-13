<?php

namespace App\DataFixtures;


use App\Entity\Company;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class CompanyFixtures extends Fixture
{
    public const COMPANIES =[
        'Nobatek',
        'Ceebios',
        'Cheops'
    ];

    public function load(ObjectManager $manager): void
    {
        foreach (self::COMPANIES as $companyName){
            $company = new Company();
            $company->setName($companyName);
            $manager->persist($company);
            $this->addReference('company_' . $companyName, $company);
        }
        $manager->flush();
    }
}
