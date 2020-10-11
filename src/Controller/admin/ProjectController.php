<?php

namespace App\Controller\admin;


use App\Entity\Project;
use App\Repository\ProjectRepository;
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
     * @param ProjectRepository $projectRepository
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function index(ProjectRepository $projectRepository, CategoryRepository $categoryRepository)
    {
        return $this->render('admin/project/index.html.twig', [
            'project' => $projectRepository->findAll(),
            'category' => $categoryRepository->findAll()
        ]);
    }

    /**
     * @Route("/{id}", name="read", requirements={"id": "\d+"})
     * @param Project $project
     * @return Response
     */
    public function read(project $project)
    {
        return $this->render('admin/project/read.html.twig', [
            'project' => $project,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", requirements={"id": "\d+"})
     * @param Project $project
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function edit(project $project, Request $request)
    {

        $form = $this->createForm(ProjectType::class, $project);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {

            $this->getDoctrine()->getManager()->flush();


            return $this->redirectToRoute('admin_project_home');
        }

        return $this->render('admin/project/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/delete/{id}", name="delete", methods={"DELETE"})
     * @param project $projects
     * @return RedirectResponse
     */
    public function delete(project $projects)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($projects);
        $em->flush();

        $this->addFlash('message', 'Projet supprimé avec succès');
        return $this->redirectToRoute('admin_project_home');
    }
}
