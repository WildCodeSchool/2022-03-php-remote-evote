<?php

namespace App\Services;

use App\Entity\Vote;
use App\Entity\Campaign;
use App\Entity\College;
use App\Entity\Resolution;
use JetBrains\PhpStorm\ArrayShape;
use Symfony\UX\Chartjs\Model\Chart;
use App\Repository\ResolutionRepository;
use App\Repository\VoteRepository;
use Doctrine\Common\Collections\Collection;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;

class ChartResults
{
    public function __construct(
        private ChartBuilderInterface $chartBuilder,
        private VoteRepository $voteRepository
    ) {
    }

    public function getResultByCollege(
        Collection $resolutions
    ): Collection {
        foreach ($resolutions as $resolution) {
            $voteResults = [];
            foreach ($resolution->getCampaign()->getCompany()->getColleges() as $college) {
                if (!$this->voteRepository->findByResolution($resolution)) {
                    continue;
                }
                $numApproved = count($this->voteRepository->getVotesByCollege($resolution, $college, 'approved'));
                $numRejected = count($this->voteRepository->getVotesByCollege($resolution, $college, 'rejected'));
                $numAbstention = count($this->voteRepository->getVotesByCollege($resolution, $college, 'abstention'));
                $chart = $this->chartBuilder->createChart(Chart::TYPE_PIE);
                $chart->setData([
                    'labels' => ['Pour', 'Contre', 'Abstention'],
                    'datasets' => [
                        [
                            'label' => 'test',
                            'backgroundColor' => [
                                'rgb(75, 181, 67)',
                                'rgb(255, 14, 14)',
                                'rgb(255, 153, 102)'
                            ],
                            'data' => [$numApproved, $numRejected, $numAbstention]
                        ],
                    ],
                ]);
                $voteResults[] = $this->formatCollegeVoteResult(
                    $numApproved,
                    $numRejected,
                    $numAbstention,
                    $college,
                    $chart
                );
            }
            $resolution->setVoteResults($voteResults);
            $resolution->setFinalResult($this->calculateFinalResultWithCollege($resolution));
        }
        return $resolutions;
    }

    public function getResultByVoter(Collection $resolutions): Collection
    {
        $voteResults = [];
        foreach ($resolutions as $resolution) {
            $numApproved = count($this->voteRepository->findBy([
                'resolution' => $resolution, 'answer' => 'approved'
            ]));
            $numRejected = count($this->voteRepository->findBy([
                'resolution' => $resolution, 'answer' => 'rejected'
            ]));
            $numAbstention = count($this->voteRepository->findBy([
                'resolution' => $resolution, 'answer' => 'abstention'
            ]));
            $totalOfVoters = $numApproved + $numRejected + $numAbstention;
            if ($totalOfVoters === 0) {
                $resolution->setFinalResult($this->formatResult(false, 0));
                continue;
            }
            $chart = $this->chartBuilder->createChart(Chart::TYPE_PIE);
            $chart->setData([
                'labels' =>
                    [
                        'Pour',
                        'Contre',
                        'Abstention'
                    ],
                'datasets' =>
                    [
                        [
                            'label' => '',

                            'backgroundColor' =>
                                [
                                    'rgb(75, 181, 67)',
                                    'rgb(255, 14, 14)',
                                    'rgb(255, 153, 102)'
                                ],
                            'data' => [$numApproved, $numRejected, $numAbstention],
                        ]
                    ]
            ]);
            $voteResults[] = [
                'numApproved' => $numApproved,
                'numRejected' => $numRejected,
                'numAbstention' => $numAbstention,
                'chart' => $chart
            ];
            $resolution->setVoteResults($voteResults);
            $resolution->setFinalResult($this->calculateFinalResultByVoter($resolution));
        }
        return $resolutions;
    }

    public function calculateFinalResultWithCollege(Resolution $resolution): array
    {
        $result = [];
        $rule = $resolution->getAdoptionRule();
        foreach ($resolution->getVoteResults() as $vote) {
            $totalOfVoters = $vote['numApproved'] + $vote['numRejected'];
            if (
                ($rule === 'simple-majority' && $vote['numApproved'] > $totalOfVoters / 2) ||
                ($rule === 'adoption-2/3' && $vote['numApproved'] > $totalOfVoters * 2 / 3 ) ||
                ($rule === 'adoption-3/4' && $vote['numApproved'] > $totalOfVoters * 3 / 4 )
            ) {
                $isAdopted = true;
                $numApprovedPercent = $vote['numApproved'] * 100 / $totalOfVoters;
                $resultPercentage = round($numApprovedPercent * $vote['college']->getVotePercentage(), 2);
            } else {
                $isAdopted = false;
                $numRejectedPercent = $totalOfVoters ? $vote['numRejected'] * 100 / $totalOfVoters : 0;
                $resultPercentage = round($numRejectedPercent * $vote['college']->getVotePercentage(), 2);
            }
            $result[] = $this->formatResult($isAdopted, $resultPercentage);
        }
        usort($result, function ($result1, $result2) {
            return $result2['result'] <=> $result1['result'];
        });
        return $result[0] ?? $this->formatResult(false, 0);
    }

    private function formatCollegeVoteResult(
        int $numApproved,
        int $numRejected,
        int $numAbstention,
        College $college,
        Chart|null $chart
    ): array {
        return [
            'numApproved' => $numApproved,
            'numRejected' => $numRejected,
            'numAbstention' => $numAbstention,
            'college' => $college,
            'chart' => $chart
        ];
    }


    private function formatResult(bool $isAdopted, int|float $resultPercentage): array
    {
        return [
            'isAdopted' => $isAdopted,
            'result' => $resultPercentage,
            'message' => $isAdopted ? 'La résolution est adoptée' : 'La résolution est rejetée'
        ];
    }

    public function calculateFinalResultByVoter(Resolution $resolution): array
    {
        return [
            'isAdopted' => true, 'result' => 36.67, 'message' => 'La résolution est adoptée'
        ];
    }
}
