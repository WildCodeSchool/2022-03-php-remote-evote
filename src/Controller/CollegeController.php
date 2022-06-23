<?php

namespace App\Controller;

use App\Entity\College;
use App\Entity\Company;
use App\Entity\Campaign;
use App\Form\CollegeType;
use App\Repository\CompanyRepository;
use App\Repository\CollegeRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/campaign', name: 'campaign_college_')]
class CollegeController extends AbstractController
{
    #[Route('/{uuid}/colleges', name: 'index')]
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

    #[Route('/{uuid}/college/{id}/edit', name: 'edit', methods: ['GET', 'POST'])]
    #[ParamConverter('campaign', options: ['mapping' => ['uuid' => 'uuid']])]
    #[ParamConverter('college', options: ['mapping' => ['id' => 'id']])]
    public function edit(
        Request $request,
        Campaign $campaign,
        College $college,
        CollegeRepository $collegeRepository
    ): Response {
        $form = $this->createForm(CollegeType::class, $college);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $collegeRepository->add($college, true);

            return $this->redirectToRoute('campaign_college_index', [
                'uuid' => $campaign->getUuid()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboard/college/edit.html.twig', [
            'campaign' => $campaign,
            'college' => $college,
            'form' => $form,
        ]);
    }

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
        return $this->renderForm('dashboard/college/new.html.twig', [
            'form' => $form,
            'campaign' => $campaign

        ]);
    }

    #[Route('/{uuid}/college/{id}/delete', name: 'delete', methods: ['POST'])]
    #[ParamConverter('campaign', options: ['mapping' => ['uuid' => 'uuid']])]
    #[ParamConverter('college', options: ['mapping' => ['id' => 'id']])]
    public function delete(
        Request $request,
        Campaign $campaign,
        College $college,
        CollegeRepository $collegeRepository
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $college->getId(), $request->request->get('_token'))) {
            $collegeRepository->remove($college, true);
        }

        return $this->redirectToRoute('campaign_college_index', [
            'uuid' => $campaign->getUuid()
        ], Response::HTTP_SEE_OTHER);
    }
}
