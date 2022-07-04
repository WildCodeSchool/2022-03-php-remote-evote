<?php

namespace App\Controller;

use App\Entity\Campaign;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/voter', name: 'voter_')]
class VoteController extends AbstractController
{
    #[Route('/{uuid}', name: 'welcome')]
    public function index(Campaign $campaign): Response
    {
        return $this->render('vote/index.html.twig', [
            'campaign' => $campaign,
        ]);
    }
}
