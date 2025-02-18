<?php

namespace App\Controller;

use App\Entity\Sujets;
use App\Form\SujetsType;
use App\Repository\SujetsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/sujets')]
final class SujetsController extends AbstractController{
    #[Route(name: 'app_sujets_index', methods: ['GET'])]
    public function index(SujetsRepository $sujetsRepository): Response
    {
        return $this->render('sujets/index.html.twig', [
            'sujets' => $sujetsRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_sujets_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $sujet = new Sujets();
        $form = $this->createForm(SujetsType::class, $sujet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($sujet);
            $entityManager->flush();

            return $this->redirectToRoute('app_sujets_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sujets/new.html.twig', [
            'sujet' => $sujet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sujets_show', methods: ['GET'])]
    public function show(Sujets $sujet): Response
    {
        return $this->render('sujets/show.html.twig', [
            'sujet' => $sujet,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_sujets_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Sujets $sujet, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(SujetsType::class, $sujet);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_sujets_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('sujets/edit.html.twig', [
            'sujet' => $sujet,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_sujets_delete', methods: ['POST'])]
    public function delete(Request $request, Sujets $sujet, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sujet->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($sujet);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_sujets_index', [], Response::HTTP_SEE_OTHER);
    }
}
