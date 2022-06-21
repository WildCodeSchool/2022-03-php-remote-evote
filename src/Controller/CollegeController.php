<?php

namespace App\Controller;

use App\Entity\College;
use App\Entity\Company;
use App\Entity\Campaign;
use App\Form\CollegeType;
use App\Repository\CollegeRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/campaign', name: 'campaign_college_')]
class CollegeController extends AbstractController
{
    #[Route('/{uuid}/college/new', name: 'new')]
    public function new(
        Request $request,
        CollegeRepository $collegeRepository,
        Campaign $campaign,
        ): Response {
    $college = new College();
    $form = $this->createForm(CollegeType::class, $college);
    $form->handleRequest($request);
    if ($form->isSubmitted() && $form->isValid()) {
        $college->setCompany($campaign->getCompany());
        $collegeRepository->add($college, true);
    }
    return $this->renderForm('college/new.html.twig', [
        'form' => $form,
        'college' => $college,
    ]);
}

#[Route('/{uuid}/college', name: 'index')]
public function resolutions(Campaign $campaign): Response
{
    return $this->render('college/college.html.twig', [
        'campaign' => $campaign,
    ]);
}
}