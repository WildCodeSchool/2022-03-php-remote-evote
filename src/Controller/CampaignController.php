<?php

namespace App\Controller;

use App\Entity\Campaign;
use App\Repository\CampaignRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Uid\Uuid;

#[Route('/campaign', name: 'campaign_')]
class CampaignController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(CampaignRepository $campaignRepository): Response
    {
        $campaigns = $campaignRepository->findAll(); 
        return $this->render('campaign/index.html.twig', [
            'campaigns' => $campaigns,

        ]);
    }
     #[Route('/{uuid}/participants', name: 'voters')]
     public function showVoters(Campaign $campaign): Response
     {
        return $this->render('campaign/show-voters.html.twig', [
            'campaign' => $campaign,
         ]);
     }

     #[Route('/{uuid}/colleges', name: 'colleges')]
     public function colleges(Campaign $campaign): Response
     {
         return $this->render('campaign/colleges.html.twig', [
            'campaigns' => $campaign,
         ]);
     }

    #[Route('/{uuid}/resolutions', name: 'resolutions')]
    public function resolutions(Campaign $campaign): Response
    {
          return $this->render('campaign/resolutions.html.twig', [
            'campaigns' => $campaign,
         ]);
    }

    #[Route('/{uuid}/resultats', name: 'resultats')]
    public function resultats(Campaign $campaign): Response
    {
          return $this->render('campaign/resultats.html.twig', [
            'campaigns' => $campaign,
         ]);
    }

}
