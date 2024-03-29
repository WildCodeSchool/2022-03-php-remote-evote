<?php

namespace App\Controller;

use DateTime;
use App\Entity\Company;
use App\Entity\Campaign;
use App\Form\CampaignType;
use Symfony\Component\Uid\Uuid;
use App\Repository\CompanyRepository;
use App\Repository\CampaignRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/campaign', name: 'campaign_')]
class CampaignController extends AbstractController
{
    #[Route('/', name: 'index')]
    public function index(
        CampaignRepository $campaignRepository,
        PaginatorInterface $paginator,
        Request $request,
    ): Response {
        $query = $campaignRepository->queryAll();
        $pagination = $paginator->paginate($query, $request->query->getInt('page', 1), 10);

        return $this->render('dashboard/campaign/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    #[Route('/new', name: 'new')]
    public function new(
        Request $request,
        CampaignRepository $campaignRepository,
        CompanyRepository $companyRepository
    ): Response {
        $campaign = new Campaign();

        $form = $this->createForm(CampaignType::class, $campaign);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $campaign->setStatus(false);
            $companyName = $form->get('company')->getData();
            if (!empty($companyName)) {
                $company = $companyRepository->findOneByName($companyName);
                if (!$company) {
                    $company = new Company();
                    $company->setName($companyName);
                }
                $campaign->setCompany($company);
            }
            $uuid = Uuid::v4();
            $campaign->setUuid($uuid->toRfc4122());
            $campaign->setOwnedBy($this->getUser());
            $campaignRepository->add($campaign, true);
            $this->addFlash(
                'success',
                'La campagne ' . $campaign->getName() . ' a bien été créée '
            );
            return $this->redirectToRoute('campaign_new');
        }

        return $this->renderForm('dashboard/campaign/new.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/{uuid}/edit', name: 'edit')]
    public function edit(Campaign $campaign): Response
    {
        $this->denyAccessUnlessGranted('view', $campaign);
        return $this->render('dashboard/campaign/edit.html.twig', [
            'campaign' => $campaign
        ]);
    }

    #[Route('/{uuid}/activate', name: 'activate')]
    public function activate(
        Campaign $campaign,
        MailerInterface $mailer,
        CampaignRepository $campaignRepository
    ): Response {
        $this->denyAccessUnlessGranted('view', $campaign);
        if ($campaign->getEndedAt() !== null || $campaign->getStartedAt() === null) {
            $voters = $campaign->getVoters();

            foreach ($voters as $voter) {
                $email = (new TemplatedEmail())
                    ->from($this->getParameter('mailer_from'))
                    ->to($voter->getEmail())
                    ->subject($campaign->getName())
                    ->htmlTemplate('dashboard/campaign/email.html.twig')
                    ->context([
                        'voter' => $voter,
                        'campaign' => $campaign
                    ]);

                $mailer->send($email);
            }
            $campaign->setStartedAt(new DateTime("now"));
            $campaign->setEndedAt(null);
            $campaignRepository->add($campaign, true);
            $this->addFlash(
                'success',
                'La campagne ' . $campaign->getName() . ' a bien été activée '
            );
        }

        return $this->redirectToRoute('campaign_edit', ['uuid' => $campaign->getUuid()]);
    }

    #[Route('/{uuid}/desactivate', name: 'desactivate')]
    public function desactivate(Campaign $campaign, CampaignRepository $campaignRepository): Response
    {
        $this->denyAccessUnlessGranted('view', $campaign);
        if ($campaign->getStartedAt()) {
            $campaign->setEndedAt(new DateTime("now"));
            $campaignRepository->add($campaign, true);
            $this->addFlash(
                'success',
                'La campagne ' . $campaign->getName() . ' a bien été désactivée '
            );
        }

        return $this->redirectToRoute('campaign_edit', ['uuid' => $campaign->getUuid()]);
    }
}
