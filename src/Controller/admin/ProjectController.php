<?php

namespace App\Controller\admin;


use App\Entity\Image;
use App\Entity\Projects;
use App\Form\ProjectsType;
use App\Repository\ProjectsRepository;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

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
            'projects' => $projects,
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

        if($form->isSubmitted() && $form->isValid()) {
            $images = $form->get('images')->getData();
            foreach($images as $image){

                $file = md5(uniqid()) . '.' . $image->guessExtension();
                $image -> move(
                    $this->getParameter('images_directory'),
                    $file
                );
                $img = new Image();
                $img->setName($file);
                $projects -> setImage($img);

            }

            $this->getDoctrine()->getManager()->flush();


            return $this->redirectToRoute('admin_project_home');
        }

        return $this->render('admin/project/edit.html.twig', [
            'form' => $form->createView(),
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

        if($form->isSubmitted() && $form->isValid()){
            $images = $form->get('images')->getData();
            foreach($images as $image){

                $file = md5(uniqid()) . '.' . $image->guessExtension();
                $image -> move(
                    $this->getParameter('images_directory'),
                    $file
                );
                $img = new Image();
                $img->setName($file);
                $projects -> setImage($img);

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
}
