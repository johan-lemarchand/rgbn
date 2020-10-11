<?php

namespace App\Controller\admin;

use App\Entity\Partner;
use App\Repository\PartnerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/partner", name="admin_partner_")
 * @package App\Controller\Admin
 */
class PartnerController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param PartnerRepository $partnerRepository
     * @return Response
     */
    public function index(PartnerRepository $partnerRepository)
    {
        return $this->render('admin/partner/index.html.twig', [
            "partner"=> $partnerRepository->findAll()
        ]);
    }

    /**
     * @Route("/{id}", name="read", requirements={"id": "\d+"})
     * @param Partner $partner
     * @return Response
     */
    public function read(Partner $partner)
    {
        return $this->render('admin/partner/read.html.twig', [
            'partner' => $partner,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", requirements={"id": "\d+"})
     * @param Partner $partner
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function edit(Partner $partner, Request $request)
    {

        $form = $this->createForm(CategoryType::class, $partner);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();


            return $this->redirectToRoute('admin_partner_home');
        }

        return $this->render('admin/partner/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"DELETE"})
     * @param Partner $partner
     * @return RedirectResponse
     */
    public function delete(Partner $partner)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($partner);
        $em->flush();

        $this->addFlash('message', 'Partenaire supprimée avec succès');
        return $this->redirectToRoute('admin_partner_home');
    }
}
