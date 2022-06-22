<?php

namespace App\Controller;

use App\Entity\College;
use App\Entity\Company;
use App\Entity\Campaign;
use App\Form\CollegeType;
use App\Repository\CampaignRepository;
use App\Repository\CollegeRepository;
use App\Repository\CompanyRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/campaign', name: 'campaign_')]
class CollegeController extends AbstractController
{
    #[Route('/{uuid}/colleges', name: 'colleges_index')]
    public function showColleges(
        Campaign $campaign,
        CompanyRepository $companyRepository,
        CollegeRepository $collegeRepository
    ): Response {
        $company = $companyRepository->findAll();
        $colleges = $collegeRepository->findAll();
        return $this->render('dashboard/college/index.html.twig', [
            'campaign' => $campaign,
            'company' => $company,
            'colleges' => $colleges
        ]);
    }
}
