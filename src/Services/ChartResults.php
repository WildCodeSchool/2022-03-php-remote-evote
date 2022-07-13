<?php

namespace App\Services;

use App\Entity\Vote;
use App\Entity\College;
use App\Entity\Campaign;
use App\Entity\Resolution;
use App\Repository\VoteRepository;
use Symfony\UX\Chartjs\Model\Chart;
use App\Repository\ResolutionRepository;
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
            $resolution->voteResults = [];
            foreach ($resolution->getCampaign()->getCompany()->getColleges() as $college) {
                if (!$this->voteRepository->findByResolution($resolution)) {
                    continue;
                }
                $numApproved = count($this->voteRepository->getVotesByCollege($resolution, $college, 'approved'));
                $numRejected = count($this->voteRepository->getVotesByCollege($resolution, $college, 'rejected'));
                $numAbstention = count($this->voteRepository->getVotesByCollege($resolution, $college, 'abstention'));
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
                            'label' => $resolution->getVotes(),

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
                $resolution->voteResults[] = [
                    'numApproved' => $numApproved,
                    'numRejected' => $numRejected,
                    'numAbstention' => $numAbstention,
                    'college' => $college,
                    'chart' => $chart
                ];
            }
            $resolution->finalResult = $this->calculateFinalResult($resolution);
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
                        'label' => $resolution->getVotes(),

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
            $resolution->finalResult = $this->calculateFinalResult($resolution);
        }
        return $resolutions;
    }

    public function calculateFinalResult(Resolution $resolution): array
    {
        $finalResult = [
            'isAdopted' => false,
            'approvedPercentage' => 30,
            'rejectedPercentage' => 37.5,
            'message' => 'La résolution est rejetée'
        ];
        return $finalResult;
    }
}
