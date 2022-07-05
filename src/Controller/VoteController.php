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
    #[Route('/{voter_uuid}/campaign/{campaign_uuid}/resolution', name: 'resolution_index')]
    #[ParamConverter('voter', options: ['mapping' => ['voter_uuid' => 'uuid']])]
    #[ParamConverter('campaign', options: ['mapping' => ['campaign_uuid' => 'uuid']])]
    public function resolutions(Campaign $campaign): Response
    {
        return $this->render('vote/vote.html.twig', [
            'campaign' => $campaign,
        ]);
    }
}
