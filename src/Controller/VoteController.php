<?php

namespace App\Controller;

use App\Entity\Voter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
}
