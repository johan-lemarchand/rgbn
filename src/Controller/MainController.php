<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\ContactType;
use App\Repository\CategoryRepository;
use App\Repository\PartnerRepository;
use App\Repository\ProjectsRepository;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
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

    /**
     * @Route("/contact", name="contact")
     * @param Request $request
     * @param MailerInterface $mailer
     * @return Response
     * @throws TransportExceptionInterface
     */
    public function contact(Request $request, mailerInterface $mailer){
        $form = $this->createForm(ContactType::class);
        $contact = $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $email = (new TemplatedEmail())
                ->from($contact->get('email')->getData())
                ->to('johan27000@gmail.com')
                ->subject('contact pour un devis ou demande de renseignement')
                ->htmlTemplate('email/contact.html.twig')
                ->context([
                    'mail' => $contact->get('email')->getData(),
                    'message' => $contact->get('message')->getData(),
                    'telephone' => $contact->get('phone')->getData(),
                ]);
            $mailer->send($email);
            $this->addFlash('message', 'Votre e-mail a bien été envoyé');
            return $this->redirectToRoute('contact');

        }

        return $this->render('home/contact.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/partner", name="partner")
     * @param PartnerRepository $partnerRepository
     * @return Response
     */
    public function PartnerRead(PartnerRepository $partnerRepository)
    {
        return $this->render('partner/index.html.twig', [
            'partner' => $partnerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/category", name="category")
     * @param CategoryRepository $categoryRepository
     * @param PartnerRepository $partnerRepository
     * @return Response
     */
    public function CategoryBrowse(CategoryRepository $categoryRepository, PartnerRepository $partnerRepository)
    {
        return $this->render('project/index.html.twig', [
            'category' => $categoryRepository->findAll(),
            'partner' => $partnerRepository->findAll(),
        ]);
    }

    /**
     * @Route("/category/{id}", name="category_read", requirements={"id": "\d+"})
     * @param $id
     * @param PartnerRepository $partnerRepository
     * @return Response
     */
    public function ShowProjects($id,PartnerRepository $partnerRepository)
    {
        $category = $this->getDoctrine()
            ->getRepository(Category::class)
            ->find($id);
        $project = $category->getProject();

        return $this->render('project/read.html.twig', [
           'project' => $project,
            'partner' => $partnerRepository->findAll(),
        ]);

    }
    /**
     * @Route("/project/{id}", name="project_single", requirements={"id": "\d+"})
     * @param ProjectsRepository $projectsRepository
     * @param $id
     * @return Response
     */
    public function singleProject(ProjectsRepository $projectsRepository, $id)
    {
        $project = $projectsRepository->find($id);
        return $this->render('project/single.html.twig', [
            'projects' => $project,
        ]);
    }

    /**
     * @Route("/partner/{id}", name="partner_single", requirements={"id": "\d+"})
     * @param PartnerRepository $partnerRepository
     * @param $id
     * @return Response
     */
    public function singlePartner(PartnerRepository $partnerRepository, $id)
    {
        $partner = $partnerRepository->find($id);
        return $this->render('partner/single.html.twig', [
            'partner' => $partner
        ]);
    }



}
