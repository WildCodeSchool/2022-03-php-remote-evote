<?php

namespace App\Controller;

use App\Entity\ProxyFor;
use App\Form\ProxyForType;
use App\Repository\ProxyForRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/proxy/for')]
class ProxyForController extends AbstractController
{
    #[Route('/', name: 'app_proxy_for_index', methods: ['GET'])]
    public function index(ProxyForRepository $proxyForRepository): Response
    {
        return $this->render('proxy_for/index.html.twig', [
            'proxy_fors' => $proxyForRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_proxy_for_new', methods: ['GET', 'POST'])]
    public function new(Request $request, ProxyForRepository $proxyForRepository): Response
    {
        $proxyFor = new ProxyFor();
        $form = $this->createForm(ProxyForType::class, $proxyFor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $proxyForRepository->add($proxyFor, true);

            return $this->redirectToRoute('app_proxy_for_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('proxy_for/new.html.twig', [
            'proxy_for' => $proxyFor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_proxy_for_show', methods: ['GET'])]
    public function show(ProxyFor $proxyFor): Response
    {
        return $this->render('proxy_for/show.html.twig', [
            'proxy_for' => $proxyFor,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_proxy_for_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, ProxyFor $proxyFor, ProxyForRepository $proxyForRepository): Response
    {
        $form = $this->createForm(ProxyForType::class, $proxyFor);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $proxyForRepository->add($proxyFor, true);

            return $this->redirectToRoute('app_proxy_for_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('proxy_for/edit.html.twig', [
            'proxy_for' => $proxyFor,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_proxy_for_delete', methods: ['POST'])]
    public function delete(Request $request, ProxyFor $proxyFor, ProxyForRepository $proxyForRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $proxyFor->getId(), $request->request->get('_token'))) {
            $proxyForRepository->remove($proxyFor, true);
        }

        return $this->redirectToRoute('app_proxy_for_index', [], Response::HTTP_SEE_OTHER);
    }
}
