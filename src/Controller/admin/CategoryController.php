<?php

namespace App\Controller\admin;

use App\Entity\Category;
use App\Entity\Image;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/categorie", name="admin_categorie_")
 * @package App\Controller\Admin
 */
class CategoryController extends AbstractController
{
    /**
     * @Route("/", name="home")
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function index(CategoryRepository $categoryRepository)
    {
        return $this->render('admin/category/index.html.twig', [
            "category"=> $categoryRepository->findAll()
        ]);
    }

    /**
     * @Route("/{id}", name="read", requirements={"id": "\d+"})
     * @param Category $category
     * @return Response
     */
    public function read(Category $category)
    {
        return $this->render('admin/category/read.html.twig', [
            'category' => $category,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit", requirements={"id": "\d+"})
     * @param Category $category
     * @param Request $request
     * @return RedirectResponse|Response
     */
    public function edit(Category $category, Request $request)
    {

        $form = $this->createForm(CategoryType::class, $category);

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
                $category -> setImage($img);

            }

            $this->getDoctrine()->getManager()->flush();


            return $this->redirectToRoute('admin_categorie_home');
        }

        return $this->render('admin/category/edit.html.twig', [
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
            $category = new Category;

            $form = $this->createForm(CategoryType::class, $category);

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
                $category -> setImage($img);

                }
                $em = $this->getDoctrine()->getManager();
                $em->persist($category);
                $em->flush();

                return $this->redirectToRoute('admin_categorie_home');
            }

            return $this->render('admin/category/add.html.twig', [
                'form' => $form->createView()
            ]);
        }
    /**
     * @Route("/delete/{id}", name="delete", methods={"DELETE"})
     * @param Category $category
     * @return RedirectResponse
     */
    public function delete(Category $category)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($category);
        $em->flush();

        $this->addFlash('message', 'Categorie supprimée avec succès');
        return $this->redirectToRoute('admin_categorie_home');
    }
}
