<?php

namespace App\Controller\admin;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Repository\PartnerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 * @package App\Controller\Admin
 */
class AdminController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param PartnerRepository $partnerRepository
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function index(PartnerRepository $partnerRepository, CategoryRepository $categoryRepository)
    {
        return $this->render('admin/index.html.twig', [
            "partner"=> $partnerRepository->findAll(),
            "category"=> $categoryRepository->findAll()
        ]);
    }

}
