<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminVoteController extends AbstractController
{
    #[Route('/admin/vote', name: 'app_admin_vote')]
    public function index(): Response
    {
        return $this->render('dashboard/campaign/admin.html.twig', [
            'controller_name' => 'AdminVoteController',
        ]);
    }
}
