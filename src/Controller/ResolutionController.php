<?php

namespace App\Controller;

use App\Entity\Campaign;
use App\Entity\Resolution;
use App\Form\ResolutionType;
use App\Repository\ResolutionRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/campaign', name: 'campaign_resolution_')]
class ResolutionController extends AbstractController
{
    #[Route('/{uuid}/resolution/new', name: 'new')]
    public function new(
        Request $request,
        ResolutionRepository $resolutionRepository,
        Campaign $campaign,
    ): Response {
        $resolution = new Resolution();
        $form = $this->createForm(ResolutionType::class, $resolution);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $resolution->setCampaign($campaign);
            $resolutionRepository->add($resolution, true);
        }
        return $this->renderForm('dashboard/resolution/new.html.twig', [
            'form' => $form,
            'resolution' => $resolution,
            'campaign' => $campaign,
        ]);
    }

    #[Route('/{uuid}/resolution', name: 'index')]
    public function resolutions(Campaign $campaign): Response
    {
        return $this->render('resolution/resolution.html.twig', [
            'campaign' => $campaign,
        ]);
    }
}
