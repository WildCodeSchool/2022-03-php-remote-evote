<?php

namespace App\Services;

use App\Entity\Vote;
use App\Entity\Campaign;
use App\Entity\College;
use App\Entity\Resolution;
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
                $voteResults[] = [
                    'numApproved' => $numApproved,
                    'numRejected' => $numRejected,
                    'numAbstention' => $numAbstention,
                    'college' => $college,
                    'chart' => $chart
                ];
            }
            $resolution->setVoteResults($voteResults);
            $resolution->setFinalResult($this->calculateFinalResult($resolution));
        }
        return $resolutions;
    }

    public function getResultByVoter(Collection $resolutions): Collection
    {
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
            $resolution->voteResult = [
                'numApproved' => $numApproved,
                'numRejected' => $numRejected,
                'numAbstention' => $numAbstention,
                'chart' => $chart
            ];
            $resolution->setFinalResult($this->calculateFinalResult($resolution));
        }
        return $resolutions;
    }

    public function calculateFinalResult(Resolution $resolution): array
    {
        $finalResult = [];
        $result = [];
        if ($resolution->getAdoptionRule() === 'simple-majority') {
            foreach ($resolution->getVoteResults() as $vote) {
                $numApproved = $vote['numApproved'];
                $numRejected = $vote['numRejected'];
                $totalOfVoters = intval($numApproved + $numRejected);
                if ($totalOfVoters > 0) {
                    $numApprovedPercent = $numApproved * 100 / $totalOfVoters;
                    $numRejectedPercent = $numRejected * 100 / $totalOfVoters;
                    if ($numApprovedPercent > $numRejectedPercent) {
                        $isAdopted = true;
                        $resultPercentage = round($numApprovedPercent * $vote['college']->getVotePercentage(), 1);
                    } else {
                        $isAdopted = false;
                        $resultPercentage = round($numRejectedPercent * $vote['college']->getVotePercentage(), 1);
                    }
                    $result[] = [
                        'isAdopted' => $isAdopted,
                        'result' => $resultPercentage
                    ];
                } else {
                    $result[] = [
                        'isAdopted' => false,
                        'result' => 0
                    ];
                }
            }
            usort($result, function ($result1, $result2) {
                return  $result2['result'] <=> $result1['result'];
            });
            $finalResult = $result[0];
            $finalResult['message'] = $finalResult['isAdopted']
                ? 'La résolution est adoptée'
                : 'La résolution est rejetée';
        }
        return $finalResult;
    }
}
