<?php

namespace App\Controller\admin;

use App\Entity\Image;
use App\Entity\Partner;
use App\Form\PartnerType;
use App\Repository\PartnerRepository;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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

        $form = $this->createForm(PartnerType::class, $partner);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
           $image = $form->get('images')->getData();

            $lastFile = $partner->getImage();
            if($form['images']->getData() == null){
                $partner-> setImage($lastFile);
                    }
            else{
            $file = md5(uniqid()) . '.' . $image->guessExtension();
                $image -> move(
                    $this->getParameter('images_directory'),
                    $file
                );
                $img = new Image();
                $img->setName($file);
                $partner -> setImage($img);
            }
                $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_partner_home');
        }
        return $this->render('admin/partner/edit.html.twig', [
            'form' => $form->createView(),
            'partner' => $partner,
        ]);
    }

    /**
     * @Route("/add", name="add")
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function add(Request $request)
    {
        $partner = new Partner;

        $form = $this->createForm(PartnerType::class, $partner);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            $images = $form->get('images')->getData();
            $file = md5(uniqid()) . '.' . $images->guessExtension();
                $images -> move(
                    $this->getParameter('images_directory'),
                    $file
                );
                $img = new Image();
                $img->setName($file);
                $partner -> setImage($img);

            $em = $this->getDoctrine()->getManager();
            $em->persist($partner);
            $em->flush();

            return $this->redirectToRoute('admin_partner_home');
        }

        return $this->render('admin/partner/add.html.twig', [
            'form' => $form->createView()
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

        $this->addFlash('message', 'Partenaire supprimé avec succès');
        return $this->redirectToRoute('admin_partner_home');
    }

    /**
     * @Route("/delete/image/{id}", name="delete_image", requirements={"id":"\d+"}, methods={"DELETE"})
     * @param Image $image
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteImage(Image $image, Request $request)
    {
        $data = json_decode($request->getContent(), true );
        if($this->isCsrfTokenValid('delete'.$image->getId(), $data['_token'])) {
            $nom = $image->getName();
            unlink($this->getParameter('images_directory') . '/' . $nom);
            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        }else{
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }
    }
}
