<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
use App\Repository\PartnerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param CategoryRepository $categoryRepository
     * @param PartnerRepository $partnerRepository
     * @return Response
     */
    public function index(CategoryRepository $categoryRepository, PartnerRepository $partnerRepository)
    {
        return $this->render('home/index.html.twig', [
            'category' => $categoryRepository->findAll(),
            'partner' => $partnerRepository->findAll(),
        ]);
    }
}
