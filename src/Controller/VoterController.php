<?php

namespace App\Controller;

use App\Entity\Voter;
use App\Entity\Company;
use App\Form\VoterType;
use App\Entity\Campaign;
use Symfony\Component\Uid\Uuid;
use App\Repository\VoterRepository;
use App\Repository\CompanyRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/campaign', name: 'campaign_voter_')]
class VoterController extends AbstractController
{
    #[Route('/{uuid}/voters/new', name: 'new')]
    public function new(
        Request $request,
        VoterRepository $voterRepository,
        CompanyRepository $companyRepository,
        Campaign $campaign
    ): Response {
        $voter = new Voter();
        $form = $this->createForm(VoterType::class, $voter, [
            'company' => $campaign->getCompany()
        ]);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $voter->setCampaign($campaign);
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
            $this->addFlash(
                'success',
                'Le votant ' . $voter->getFullname() . ' a bien été ajouté à la campagne ' . $campaign->getName()
            );
            return $this->redirectToRoute('campaign_edit', ['uuid' => $campaign->getUuid()]);
        }

        return $this->renderForm('dashboard/voter/new.html.twig', [
            'form' => $form,
            'campaign' => $campaign
        ]);
    }
}
