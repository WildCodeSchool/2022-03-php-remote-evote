<?php

namespace App\Tests;

use App\Entity\College;
use App\Entity\Resolution;
use App\Services\ChartResults;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ChartResultsTest extends KernelTestCase
{
    public function testSimpleMajority(): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        $chartResults = static::getContainer()->get(ChartResults::class);
        $resolution = new Resolution();
        $resolution->setAdoptionRule('simple-majority');

        $college1 = new College();
        $college1->setVotePercentage(.40);
        $college2 = new College();
        $college2->setVotePercentage(.60);
        $resolution->setVoteResults([
            [
                'numApproved' => 60,//75%
                'numRejected' => 20,
                'numAbstention' => 20,
                'college' => $college1,//30%
            ],
            [
                'numApproved' => 40,
                'numRejected' => 50,//62,5%
                'numAbstention' => 10,
                'college' => $college2,//37,5%
            ]
        ]);
        $finalResult = [
            'isAdopted' => false,
            'approvedPercentage' => 30,
            'rejectedPercentage' => 37.5,
            'message' => 'La résolution est rejetée'
        ];
        $this->assertSame($finalResult, $chartResults->calculateFinalResult($resolution));
    }
}
