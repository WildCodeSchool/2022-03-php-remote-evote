<?php

namespace App\Controller;

use App\Entity\Campaign;
use App\Entity\Resolution;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

#[Route('/voter', name: 'voter_')]
class VoteController extends AbstractController
{
    #[Route('/{uuid}/resolution', name: 'index')]
    public function resolutions(Campaign $campaign): Response
    {
        return $this->render('vote/vote.html.twig', [
            'campaign' => $campaign,
        ]);
    }

    // #[Route('/{voter_uuid}/campaign/{campaign_uuid}/resolution/{resolution_uuid}/vote',
    // name: 'vote', methods: ['GET', 'POST'])]
    // #[ParamConverter('voter', options: ['mapping' => ['voter_uuid' => 'uuid']])]
    // #[ParamConverter('campaign', options: ['mapping' => ['campaign_uuid' => 'uuid']])]
    // #[ParamConverter('resolution', options: ['mapping' => ['resolution_uuid' => 'uuid']])]
    // public function vote(Campaign $campaign, Resolution $resolution): Response
    // {
    //     return $this->render('vote/show.html.twig', [
    //         'campaign' => $campaign,
    //         'resolution' => $resolution,
    //     ]);
    // }
}
