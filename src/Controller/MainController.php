<?php

namespace App\Controller;

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
     * @Route("/project", name="project")
     * @param ProjectsRepository $projectsRepository
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function ProjectBrowse(ProjectsRepository $projectsRepository, CategoryRepository $categoryRepository)
    {
        return $this->render('project/index.html.twig', [
            'project' => $projectsRepository->findAll(),
            'category' => $categoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/category/{id}", name="category_read", requirements={"id": "\d+"})
     * @param ProjectsRepository $projectsRepository
     * @param CategoryRepository $categoryRepository
     * @return Response
     */
    public function ProjectsRead(ProjectsRepository $projectsRepository, CategoryRepository $categoryRepository)
    {

        return $this->render('project/read.html.twig', [
            'projects' => $projectsRepository->findAll(),
            'category' => $categoryRepository->findAll(),
        ]);
    }

    /**
     * @Route("/project/{id}", name="project_single", requirements={"id": "\d+"})
     * @param ProjectsRepository $projectsRepository
     * @return Response
     */
    public function singleProject(ProjectsRepository $projectsRepository)
    {

        return $this->render('project/single.html.twig', [
            'project' => $projectsRepository->findAll(),
        ]);
    }



}
