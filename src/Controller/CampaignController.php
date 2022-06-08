<?php

namespace App\Controller;

use App\Entity\Campaign;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CampaignType;
use App\Repository\CampaignRepository;
use Symfony\Component\HttpFoundation\Request;

#[Route('/campaign', name: 'campaign_')]

class CampaignController extends AbstractController
{
    #[Route('/new', name: 'new')]
    public function new(Request $request, CampaignRepository $campaignRepository): Response
    {
        $campaign = new Campaign();

        $form = $this->createForm(CampaignType::class, $campaign);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $campaignRepository->add($campaign, true);
            return $this->redirectToRoute('campaign_new');
        }

        return $this->renderForm('campaign/new.html.twig', [
            'form' => $form,
        ]);
    }
}
