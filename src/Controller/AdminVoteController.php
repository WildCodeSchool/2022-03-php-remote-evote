<?php

namespace App\Controller;

use App\Entity\Campaign;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/campaign', name: 'campaign_')]
class AdminVoteController extends AbstractController
{
    #[Route('/{uuid}/admin/vote', name: 'admin')]
    public function index(Campaign $campaign): Response
    {
        return $this->render('dashboard/campaign/admin.html.twig', [
            'controller_name' => 'AdminVoteController',
            'campaign' => $campaign
        ]);
    }
}
