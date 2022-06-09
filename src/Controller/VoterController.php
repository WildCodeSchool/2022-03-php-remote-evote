<?php

namespace App\Controller;

use App\Entity\Voter;
use App\Form\VoterType;
use App\Repository\VoterRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/voter', name: 'voter_')]
class VoterController extends AbstractController
{
    #[Route('/new', name: 'new')]
    public function new(Request $request, VoterRepository $voterRepository): Response
    {
        $voter = new Voter();
        $form = $this->createForm(VoterType::class, $voter);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $voterRepository->add($voter, true);

            return $this->redirectToRoute('voter_new', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('voter/new.html.twig', [
            'form' => $form,
        ]);
    }
}
