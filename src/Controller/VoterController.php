<?php

namespace App\Controller;

use App\Entity\Voter;
use App\Entity\Company;
use App\Form\VoterType;
use App\Entity\Campaign;
use Symfony\Component\Uid\Uuid;
use App\Repository\VoterRepository;
use App\Repository\CompanyRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
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

    #[Route('/{campaign_uuid}/voter/{voter_uuid}/edit', name: 'edit', methods: ['GET', 'POST'])]
    #[ParamConverter('campaign', options: ['mapping' => ['campaign_uuid' => 'uuid']])]
    #[ParamConverter('voter', options: ['mapping' => ['voter_uuid' => 'uuid']])]
    public function edit(
        Request $request,
        Campaign $campaign,
        Voter $voter,
        VoterRepository $voterRepository
    ): Response {
        $form = $this->createForm(VoterType::class, $voter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $voterRepository->add($voter, true);

            return $this->redirectToRoute('campaign_voters_index', [
                'uuid' => $campaign->getUuid()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboard/voter/edit.html.twig', [
            'campaign' => $campaign,
            'voter' => $voter,
            'form' => $form,
        ]);
    }

    #[Route('/{campaign_uuid}/voters/{voter_uuid}/delete', name: 'delete', methods: ['GET', 'POST'])]
    #[ParamConverter('campaign', options: ['mapping' => ['campaign_uuid' => 'uuid']])]
    #[ParamConverter('voter', options: ['mapping' => ['voter_uuid' => 'uuid']])]
    public function delete(
        Request $request,
        Campaign $campaign,
        Voter $voter,
        VoterRepository $voterRepository
    ): Response {
        if ($this->isCsrfTokenValid('delete' . $voter->getUuId(), $request->request->get('_token'))) {
            $voterRepository->remove($voter, true);
        }
        return $this->redirectToRoute('campaign_voters_index', [
            'uuid' => $campaign->getUuid()
        ], Response::HTTP_SEE_OTHER);
    }
}
