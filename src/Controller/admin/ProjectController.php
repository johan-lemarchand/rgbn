<?php

namespace App\Controller\admin;


use App\Entity\Image;
use App\Entity\ImageAfter;
use App\Entity\ImageBefore;
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
            $imageBefore = $form->get('imageBefore')->getData();
            $imageAfter = $form->get('imageAfter')->getData();


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

            $lastFile = $projects->getImageAfter();
            if($form['imageAfter']->getData() == null){
                $projects-> setImageAfter($lastFile);
            }
            else {
                $file = md5(uniqid()) . '.' . $imageAfter->guessExtension();
                $imageAfter->move(
                    $this->getParameter('images_directory'),
                    $file
                );
                $img = new ImageAfter();
                $img->setName($file);
                $projects->setImageAfter($img);
            }
            $lastFile = $projects->getImageBefore();
            if($form['imageBefore']->getData() == null){
                $projects-> setImageBefore($lastFile);
            }
            else {
                $file = md5(uniqid()) . '.' . $imageBefore->guessExtension();
                $imageBefore->move(
                    $this->getParameter('images_directory'),
                    $file
                );
                $img = new ImageBefore();
                $img->setName($file);
                $projects->setImageBefore($img);
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
            $imageBefore = $form->get('imageBefore')->getData();
            $imageAfter = $form->get('imageAfter')->getData();
            $images = $form->get('images')->getData();

            $obligFile = null;
            if($form['images']->getData() == null){
                $projects-> addImage($obligFile);
            }
            else {

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
            }
            if($form['imageBefore']->getData() == null){
                $projects-> setImageBefore($obligFile);
            }
            else {

                $file = md5(uniqid()) . '.' . $imageBefore->guessExtension();
                $imageBefore->move(
                    $this->getParameter('images_directory'),
                    $file
                );
                $img = new ImageBefore();
                $img->setName($file);
                $projects->setImageBefore($img);
            }
            if($form['imageAfter']->getData() == null){
                $projects-> setImageAfter($obligFile);
            }
            else {
                $file = md5(uniqid()) . '.' . $imageAfter->guessExtension();
                $imageAfter->move(
                    $this->getParameter('images_directory'),
                    $file
                );
                $img = new ImageAfter();
                $img->setName($file);
                $projects->setImageAfter($img);
            }
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
     * @Route("/delete/{id}", name="delete", requirements={"id":"\d+"}, methods={"DELETE"})
     * @param projects $projects
     * @return RedirectResponse
     */
    public function delete(projects $projects)
    {

        $em = $this->getDoctrine()->getManager();
        $projects->setImageAfter(null);
        $projects->setImageBefore(null);
        $em->flush();
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
        if($this->isCsrfTokenValid('delete'.$image->getId(), $data['_token']))  {
            $nom = $image->getName();
            unlink($this->getParameter('images_directory') . '/' . $nom);
            $em = $this->getDoctrine()->getManager();
            $em->remove($image);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        }
       else{
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }

    }
    /**
     * @Route("/delete/imageBefore/{id}", name="delete_image_before", requirements={"id":"\d+"}, methods={"DELETE"})
     * @param ImageBefore $imageBefore
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteImageBefore(ImageBefore $imageBefore, Request $request)
    {
        $data = json_decode($request->getContent(), true );
        if($this->isCsrfTokenValid('delete'.$imageBefore->getId(), $data['_token']))  {
            $nom = $imageBefore->getName();
            unlink($this->getParameter('images_directory') . '/' . $nom);
            $em = $this->getDoctrine()->getManager();
            $em->remove($imageBefore);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        }
        else{
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }

    }
    /**
     * @Route("/delete/imageAfter/{id}", name="delete_image_after", requirements={"id":"\d+"}, methods={"DELETE"})
     * @param ImageAfter $imageAfter
     * @param Request $request
     * @return JsonResponse
     */
    public function deleteImageAfter(ImageAfter $imageAfter, Request $request)
    {
        $data = json_decode($request->getContent(), true );
        if($this->isCsrfTokenValid('delete'.$imageAfter->getId(), $data['_token']))  {
            $nom = $imageAfter->getName();
            unlink($this->getParameter('images_directory') . '/' . $nom);
            $em = $this->getDoctrine()->getManager();
            $em->remove($imageAfter);
            $em->flush();

            return new JsonResponse(['success' => 1]);
        }
        else{
            return new JsonResponse(['error' => 'Token Invalide'], 400);
        }

    }
}
