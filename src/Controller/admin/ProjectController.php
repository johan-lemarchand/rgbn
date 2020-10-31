<?php

namespace App\Controller\admin;


use App\Entity\Image;
use App\Entity\Projects;
use App\Form\ProjectsType;
use App\Repository\ProjectsRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Constraints\Json;

/**
 * @Route("/admin/project", name="admin_project_")
 * @package App\Controller\Admin
 */
class ProjectController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param ProjectsRepository $projectsRepository
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function index(ProjectsRepository $projectsRepository, CategoryRepository $categoryRepository)
    {
        return $this->render('admin/project/index.html.twig', [
            'project' => $projectsRepository->findAll(),
            'category' => $categoryRepository->findAll()
        ]);
    }

    /**
     * @Route("/{id}", name="read", requirements={"id": "\d+"})
     * @param Projects $projects
     * @return Response
     */
    public function read(projects $projects)
    {
        return $this->render('admin/project/read.html.twig', [
            'project' => $projects,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", requirements={"id": "\d+"})
     * @param Projects $projects
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function edit(projects $projects, Request $request)
    {

        $form = $this->createForm(ProjectsType::class, $projects);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $images = $form->get('images')->getData();
            $imgBefore = $form->get('imgBefore')->getData();
            $imgAfter = $form->get('imgAfter')->getData();


            foreach ($images as $image) {
                $file = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $file
                );
                $img = new Image();
                $img->setName($file);
                $projects->addImage($img);
            }

            $lastFile = $projects->getImgAfter();
            if($form['imgAfter']->getData() == null){
                $projects-> setImgAfter($lastFile);
            }
            else {
                $file = md5(uniqid()) . '.' . $imgAfter->guessExtension();
                $imgAfter->move(
                    $this->getParameter('images_directory'),
                    $file
                );
                $img = new Image();
                $img->setName($file);
                $projects->setImgAfter($img);
            }
            $lastFile = $projects->getImgBefore();
            if($form['imgBefore']->getData() == null){
                $projects-> setImgBefore($lastFile);
            }
            else {
                $file = md5(uniqid()) . '.' . $imgBefore->guessExtension();
                $imgBefore->move(
                    $this->getParameter('images_directory'),
                    $file
                );
                $img = new Image();
                $img->setName($file);
                $projects->setImgBefore($img);
            }

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_project_home');
        }

        return $this->render('admin/project/edit.html.twig', [
            'form' => $form->createView(),
            'project' => $projects,
        ]);
    }

    /**
     * @Route("/add", name="add")
     * @param Request $request
     * @return RedirectResponse|Response
     */

    public function add(Request $request)
    {
        $projects = new Projects;

        $form = $this->createForm(ProjectsType::class, $projects);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $imgBefore = $form->get('imgBefore')->getData();
            $imgAfter = $form->get('imgAfter')->getData();
            $images = $form->get('images')->getData();

            foreach ($images as $image) {

                $file = md5(uniqid()) . '.' . $image->guessExtension();
                $image->move(
                    $this->getParameter('images_directory'),
                    $file
                );
                $img = new Image();
                $img->setName($file);
                $projects->addImage($img);

            }

            $file = md5(uniqid()) . '.' . $imgBefore->guessExtension();
            $imgBefore -> move(
                $this->getParameter('images_directory'),
                $file
            );
            $img = new Image();
            $img->setName($file);
            $projects -> setImgBefore($img);


            $file = md5(uniqid()) . '.' . $imgAfter->guessExtension();
            $imgAfter -> move(
                $this->getParameter('images_directory'),
                $file
            );
            $img = new Image();
            $img->setName($file);
            $projects -> setImgAfter($img);

            $em = $this->getDoctrine()->getManager();
            $em->persist($projects);
            $em->flush();

            return $this->redirectToRoute('admin_project_home');
        }

        return $this->render('admin/project/add.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"DELETE"})
     * @param projects $projects
     * @return RedirectResponse
     */
    public function delete(projects $projects)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($projects);
        $em->flush();

        $this->addFlash('message', 'Projet supprimé avec succès');
        return $this->redirectToRoute('admin_project_home');
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
