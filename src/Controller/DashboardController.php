<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/', name: 'dashboard_')]
class DashboardController extends AbstractController
{
    #[Route('dashboard', name: 'index')]
    public function index(): Response
    {
        return $this->render('dashboard/index.html.twig');
    }
}