<?php

namespace App\Controller;

use App\Entity\Voter;
use App\Entity\Campaign;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

#[Route('/voter', name: 'voter_')]
class VoteController extends AbstractController
{
    #[Route('/{uuid}', name: 'welcome')]
    public function index(Voter $voter): Response
    {
        return $this->render('vote/index.html.twig', [
            'voter' => $voter
        ]);
    }

    #[Route('/{voter_uuid}/campaign/{campaign_uuid}/resolution', name: 'resolution_index', methods: ['GET'])]
    #[ParamConverter('voter', options: ['mapping' => ['voter_uuid' => 'uuid']])]
    #[ParamConverter('campaign', options: ['mapping' => ['campaign_uuid' => 'uuid']])]
    public function resolutions(Campaign $campaign, Voter $voter): Response
    {
        return $this->render('vote/vote.html.twig', [
            'campaign' => $campaign,
            'voter' => $voter
        ]);
    }
}
