<?php

namespace App\Controller;

use App\Entity\Voter;
use App\Entity\Company;
use App\Entity\Campaign;
use App\Form\CampaignType;
use Symfony\Component\Uid\Uuid;
use App\Repository\CompanyRepository;
use App\Repository\CampaignRepository;
use App\Repository\VoterRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    #[Route('/{uuid}/participants', name: 'voters_index')]
    public function showVoters(Campaign $campaign, VoterRepository $voterRepository): Response
    {
        $voters = $voterRepository->findAll();
        return $this->render('campaign/show-voters.html.twig', [
            'voters' => $voters,
            'campaign' => $campaign
            
        ]);
    }

    #[Route('/{uuid}/colleges', name: 'colleges_index')]
    public function colleges(Campaign $campaign): Response
    {
        return $this->render('campaign/colleges.html.twig', [
            'campaign' => $campaign,
        ]);
    }

    #[Route('/{uuid}/resolutions', name: 'resolutions_index')]
    public function resolutions(Campaign $campaign): Response
    {
        return $this->render('campaign/resolutions.html.twig', [
            'campaign' => $campaign,
        ]);
    }

    #[Route('/{uuid}/resultats', name: 'resultats_index')]
    public function resultats(Campaign $campaign): Response
    {
        return $this->render('campaign/resultats.html.twig', [
            'campaign' => $campaign,
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(
        Request $request,
        CampaignRepository $campaignRepository,
        CompanyRepository $companyRepository
    ): Response {
        $campaign = new Campaign();

        $form = $this->createForm(CampaignType::class, $campaign);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $companyName = $form->get('company')->getData();
            if (!empty($companyName)) {
                $company = $companyRepository->findOneByName($companyName);
                if (!$company) {
                    $company = new Company();
                    $company->setName($companyName);
                }
                $campaign->setCompany($company);
            }
            $uuid = Uuid::v4();
            $campaign->setUuid($uuid->toRfc4122());
            $campaignRepository->add($campaign, true);
            return $this->redirectToRoute('campaign_new');
        }

        return $this->renderForm('campaign/new.html.twig', [
            'form' => $form,

        ]);
    }
}
