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
            $resolution->charts = [];
            foreach ($resolution->getCampaign()->getCompany()->getColleges() as $college) {
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
                            'data' => [
                                count($this->voteRepository->getVotesByCollege($resolution, $college, 'approved')),
                                count($this->voteRepository->getVotesByCollege($resolution, $college, 'rejected')),
                                count($this->voteRepository->getVotesByCollege($resolution, $college, 'abstention'))
                            ]
                        ],
                    ],
                ]);
                $resolution->charts[] = $chart;
            }
        }
        return $resolutions;
    }
}
