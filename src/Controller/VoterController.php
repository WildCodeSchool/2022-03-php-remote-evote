<?php

namespace App\Controller;

use App\Entity\Voter;
use App\Entity\Company;
use App\Form\VoterType;
use Symfony\Component\Uid\Uuid;
use App\Repository\VoterRepository;
use App\Repository\CompanyRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/voter', name: 'voter_')]
class VoterController extends AbstractController
{
    #[Route('/new', name: 'new')]
    public function new(
        Request $request,
        VoterRepository $voterRepository,
        CompanyRepository $companyRepository
    ): Response {
        $voter = new Voter();

        $form = $this->createForm(VoterType::class, $voter);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $companyName = $form->get('company')->getData();
            if (!empty($companyName)) {
                $company = $companyRepository->findOneByName($companyName);
                if (!$company) {
                    $company = new Company();
                    $company->setName($companyName);
                }
                $voter->setCompany($company);
            }
            $uuid = Uuid::v4();
            $voter->setUuid($uuid->toRfc4122());
            $voterRepository->add($voter, true);
            return $this->redirectToRoute('voter_new');
        }

        return $this->renderForm('voter/new.html.twig', [
            'form' => $form,
        ]);
    }
}
