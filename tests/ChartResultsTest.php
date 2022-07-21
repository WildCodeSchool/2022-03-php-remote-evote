<?php

namespace App\Tests;

use App\Entity\College;
use App\Entity\Resolution;
use App\Entity\Vote;
use App\Entity\Voter;
use App\Repository\ResolutionRepository;
use App\Repository\VoterRepository;
use App\Services\ChartResults;
use phpDocumentor\Reflection\Types\String_;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

class ChartResultsTest extends KernelTestCase
{
    /**
     * @dataProvider provideRule
     */
    public function testCalculateFinalResultWithCollege(array $finalResult, string $rule): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());
        $chartResults = static::getContainer()->get(ChartResults::class);
        $resolution = new Resolution();
        $resolution->setAdoptionRule($rule);

        $college1 = new College();
        $college1->setVotePercentage(.40);
        $college2 = new College();
        $college2->setVotePercentage(.60);
        $resolution->setVoteResults([
            [
                'numApproved' => 20,//25%
                'numRejected' => 60,//75%
                'numAbstention' => 20,
                'college' => $college1,//resultat : non. poids 30%
            ],
            [
                'numApproved' => 55,//61.11%
                'numRejected' => 35,//38.89%
                'numAbstention' => 10,
                'college' => $college2,//resultat : oui. poids 36.67%
            ]
        ]);

        $this->assertSame($finalResult, $chartResults->calculateFinalResultWithCollege($resolution));
    }

    public function provideRule(): array
    {
        return [
            [['isAdopted' => true, 'result' => 36.67, 'message' => 'La résolution est adoptée'], 'simple-majority'],
            [['isAdopted' => false, 'result' => 30.0, 'message' => 'La résolution est rejetée'], 'adoption-2/3'],
            [['isAdopted' => false, 'result' => 30.0, 'message' => 'La résolution est rejetée'], 'adoption-3/4'],
        ];
    }

    /**
     * @dataProvider provideAnswer
     */
    public function testCalculateVotePercentageByAnswer(float $result, string $answer): void
    {
        $kernel = self::bootKernel();

        $this->assertSame('test', $kernel->getEnvironment());

        $chartResults = static::getContainer()->get(ChartResults::class);
        $resolutionRepository = static::getContainer()->get(ResolutionRepository::class);
        $resolution = $resolutionRepository->find(2);

        $this->assertSame($result, $chartResults->calculateVotePercentageByAnswer($resolution, $answer));
    }

    public function provideAnswer(): array
    {
        return [
          [45.0, 'approved'],
          [32.14, 'rejected'],
          [22.86, 'abstention'],
        ];
    }
}
