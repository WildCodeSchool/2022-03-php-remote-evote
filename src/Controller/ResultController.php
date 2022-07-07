<?php

namespace App\Controller;

use App\Entity\Campaign;
use App\Entity\Resolution;
use Symfony\UX\Chartjs\Model\Chart;
use App\Repository\CampaignRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\UX\Chartjs\Builder\ChartBuilderInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

#[Route('/results', name: 'results_')]
class ResultController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CampaignRepository $campaignRepository): Response
    {
        $campaigns = $campaignRepository->findAll();
        return $this->render('dashboard/campaign/results/index.html.twig', [
            'campaigns' => $campaigns,
        ]);
    }

    #[Route('/{uuid}/show', name: 'show')]
    public function showResults(
        Campaign $campaign,
        ChartBuilderInterface $chartBuilder
    ): Response {
        $charts = [];
        if ($campaign->getHasCollege(true)) {
        foreach ($campaign->getCompany()->getColleges() as $college) {
                $chart = $chartBuilder->createChart(Chart::TYPE_PIE);
                $chart->setData([
                    'labels' => ['Pour', 'Contre', 'Abstention'],
                    'datasets' => [
                        [
                            'label' => $college->getName(),
                            'backgroundColor' => [
                                'rgb(75, 181, 67)',
                                'rgb(255, 14, 14)',
                                'rgb(255, 153, 102)'
                            ],
                            'data' => [300, 25, 75]
                        ],
                    ],
                ]);
                $charts[] = $chart;
            }
        } else {
            
            foreach ($campaign->getVoters() as $voter) {
                $chart = $chartBuilder->createChart(Chart::TYPE_PIE);
                $chart->setData([
                    'labels' => ['Pour', 'Contre', 'Abstention'],
                    'datasets' => [
                        [
                            'label' => $voter->getFullname(),
                            'backgroundColor' => [
                                'rgb(75, 181, 67)',
                                'rgb(255, 14, 14)',
                                'rgb(255, 153, 102)'
                            ],
                            'data' => [300, 25, 75]
                        ],
                    ],
                ]);
                $charts[] = $chart;
            }
        }

        return $this->render('dashboard/campaign/results/show.html.twig', [
            'charts' => $charts,
            'campaign' => $campaign
        ]);
    }
}
