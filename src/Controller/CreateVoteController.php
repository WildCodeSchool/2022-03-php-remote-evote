<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/evote/creer-vote', methods: ['GET'], name: 'create_vote_')]
class CreateVoteController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('create_vote/index.html.twig', [
            'controller_name' => 'CreateVoteController',
        ]);
    }
}
