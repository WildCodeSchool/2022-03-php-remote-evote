<?php

namespace App\Controller;

use App\Entity\Vote;
use App\Entity\Voter;
use App\Entity\Campaign;
use App\Services\ChartResults;
use App\Repository\VoteRepository;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/{voter_uuid}/campaign/{campaign_uuid}/results', name: 'results', methods: ['GET'])]
    #[ParamConverter('campaign', options: ['mapping' => ['campaign_uuid' => 'uuid']])]
    #[ParamConverter('voter', options: ['mapping' => ['voter_uuid' => 'uuid']])]
    public function resultVoters(
        Campaign $campaign,
        ChartResults $chartResults
    ): Response {
        if ($campaign->getHasCollege()) {
            $resolutionsCharts = $chartResults->getResultByCollege(
                $campaign->getResolutions()
            );
        } else {
            $resolutionsCharts = $chartResults->getResultByVoter(
                $campaign->getResolutions()
            );
        }

        return $this->render('vote/results.html.twig', [
            'campaign' => $campaign,
            'resolutions' => $resolutionsCharts,
        ]);
    }

    #[Route('/{uuid}/vote/{id}/delete', name: 'delete', methods: ['POST'])]
    #[ParamConverter('voter', options: ['mapping' => ['uuid' => 'uuid']])]
    #[ParamConverter('vote', options: ['mapping' => ['id' => 'id']])]
    public function delete(
        Request $request,
        Voter $voter,
        Vote $vote,
        VoteRepository $voteRepository
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $vote->getId(), $request->request->get('_token'))) {
            $voteRepository->remove($vote, true);
        }

        return $this->redirectToRoute('voter_resolution_index', [
            'voter_uuid' => $voter->getUuid(),
            'campaign_uuid' => $voter->getCampaign()->getUuid()
        ], Response::HTTP_SEE_OTHER);
    }
}
