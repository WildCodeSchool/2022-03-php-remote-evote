<?php

namespace App\Controller;

use App\Entity\Campaign;
use App\Entity\Resolution;
use Symfony\UX\Chartjs\Model\Chart;
use App\Repository\CampaignRepository;
use App\Services\ChartResults;
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
        ChartResults $chartResults,
    ): Response {
         if ($campaign->getHasCollege()) {
             $resolutionsCharts = $chartResults->getResultByCollege(
                 $campaign->getResolutions()
             );
         } else {
             //créer le service pour afficher les votes des utilisateurs qui ne sont pas associés à un collège
//             $resolutionsCharts = $chartResults->getResultByVoter(
//                 $campaign->getResolutions()
//             );
         }


        return $this->render('dashboard/campaign/results/show.html.twig', [
            'campaign' => $campaign,
            'resolutions' => $resolutionsCharts
        ]);
    }
}
