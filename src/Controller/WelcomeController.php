<?php

namespace App\Controller;

use App\Entity\Campaign;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/welcome', name: 'welcome_')]
class WelcomeController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(): Response
    {
        return $this->render('dashboard/welcome/index.html.twig', [
            'controllername' => 'WelcomeController',
        ]);
    }
}
