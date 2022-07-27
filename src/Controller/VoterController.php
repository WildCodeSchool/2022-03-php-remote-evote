<?php

namespace App\Controller;

use App\Entity\Voter;
use App\Entity\Company;
use App\Form\VoterType;
use App\Entity\Campaign;
use App\Service\VoterManager;
use Symfony\Component\Uid\Uuid;
use App\Repository\VoterRepository;
use App\Repository\CompanyRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Loader\Configurator\form;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

#[Route('/campaign', name: 'campaign_voter_')]
class VoterController extends AbstractController
{
    #[Route('/{uuid}/voters', name: 'index')]
    public function index(Campaign $campaign): Response
    {
        $this->denyAccessUnlessGranted('view', $campaign);
        return $this->render('dashboard/voter/index.html.twig', [
            'campaign' => $campaign
        ]);
    }

    #[Route('/{uuid}/voters/new', name: 'new')]
    public function new(
        Request $request,
        VoterRepository $voterRepository,
        CompanyRepository $companyRepository,
        Campaign $campaign
    ): Response {
        $this->denyAccessUnlessGranted('view', $campaign);
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
            return $this->redirectToRoute('campaign_voter_index', [
                'uuid' => $campaign->getUuid()
            ], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('dashboard/voter/new.html.twig', [
            'form' => $form,
            'campaign' => $campaign
        ]);
    }

    #[Route('/{campaign_uuid}/voters/{voter_uuid}/edit', name: 'edit', methods: ['GET', 'POST'])]
    #[ParamConverter('campaign', options: ['mapping' => ['campaign_uuid' => 'uuid']])]
    #[ParamConverter('voter', options: ['mapping' => ['voter_uuid' => 'uuid']])]
    public function edit(
        Request $request,
        Campaign $campaign,
        Voter $voter,
        VoterRepository $voterRepository
    ): Response {
        $this->denyAccessUnlessGranted('view', $campaign);
        $form = $this->createForm(VoterType::class, $voter, [
            'company' => $campaign->getCompany()
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $voterRepository->add($voter, true);
            $this->addFlash(
                'success',
                'Le votant ' . $voter->getFullname() . ' a bien été modifié' . $campaign->getName()
            );

            return $this->redirectToRoute('campaign_voter_index', [
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
        $this->denyAccessUnlessGranted('view', $campaign);
        if ($this->isCsrfTokenValid('delete' . $voter->getUuId(), $request->request->get('_token'))) {
            $voterRepository->remove($voter, true);
            $this->addFlash(
                'success',
                'Le votant ' . $voter->getFullname() . ' a bien été supprimé de la campagne ' . $campaign->getName()
            );
        }
        return $this->redirectToRoute('campaign_voter_index', [
            'uuid' => $campaign->getUuid()
        ], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{uuid}/voters/import-csv', name: 'import_csv')]
    public function importCsv(
        VoterManager $voterManager,
        Campaign $campaign,
        Request $request
    ): Response {
        $this->denyAccessUnlessGranted('view', $campaign);
        $form = $this->createFormBuilder()
            ->add('file', FileType::class, [
                'label' => 'Fichier csv',
                'help' => 'Séléctionner un fichier csv sur votre ordinateur puis valider
                pour la synchronisation automatique des participants au vote',
                'constraints' => [
                    new File([
                        'maxSize' => '2M'
                    ])
                ]
            ])
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            //appel du service ImportVoter qui relie les votants du fichier télécharger à la campagne
            $voterManager->importVoter($campaign, $form->get('file')->getData());

            return $this->redirectToRoute('campaign_voter_index', ['uuid' => $campaign->getUuid()]);
        }
        return $this->renderForm('dashboard/voter/import-csv.html.twig', [
            'form' => $form,
            'campaign' => $campaign
        ]);
    }
}
