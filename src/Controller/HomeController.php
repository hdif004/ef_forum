<?php

namespace App\Controller;

use App\Entity\Sujets;
use App\Repository\SujetsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController{
    #[Route('/', name: 'app_home')]
    public function index(SujetsRepository $sujetsRepository): Response
    {
        $sujets = $sujetsRepository->findAll();

        return $this->render('home/index.html.twig', [
            'sujets' => $sujets,
            'controller_name' => 'HomeController',
        ]);
    }
}
