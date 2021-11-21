<?php

namespace App\Controller;

use App\Form\JobType;
use App\Form\UserType;
use App\Entity\Technicien;
use App\Entity\Intervention;
use App\Form\TechnicienType;
use App\Form\InterventionType;
use App\Repository\TechnicienRepository;
use App\Repository\InterventionRepository;
use Knp\Component\Pager\Pagination\PaginationInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[Route('/technicien')]
class TechnicienController extends AbstractController
{
    /*  #[Route('/', name: 'technicien_index', methods: ['GET'])]
    public function index(TechnicienRepository $technicienRepository): Response
    {
        return $this->render('technicien/index.html.twig', [
            'techniciens' => $technicienRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'technicien_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $technicien = new Technicien();
        $form = $this->createForm(TechnicienType::class, $technicien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($technicien);
            $entityManager->flush();

            return $this->redirectToRoute('technicien_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('technicien/new.html.twig', [
            'technicien' => $technicien,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'technicien_show', methods: ['GET'], requirements: ["id" => "\d+"])]
    public function show(Technicien $technicien): Response
    {
        return $this->render('technicien/show.html.twig', [
            'technicien' => $technicien,
        ]);
    }

    #[Route('/{id}/edit', name: 'technicien_edit', methods: ['GET', 'POST'], requirements: ['id' => '\d+'])]
    public function edit(Request $request, Technicien $technicien): Response
    {
        $form = $this->createForm(TechnicienType::class, $technicien);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('technicien_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('technicien/edit.html.twig', [
            'technicien' => $technicien,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'technicien_delete', methods: ['POST'])]
    public function delete(Request $request, Technicien $technicien): Response
    {
        if ($this->isCsrfTokenValid('delete' . $technicien->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($technicien);
            $entityManager->flush();
        }

        return $this->redirectToRoute('technicien_index', [], Response::HTTP_SEE_OTHER);
    } */

    #[Route('/jobs', name: 'jobs_index', methods: ['GET'])]
    public function jobsTechnicien(PaginatorInterface $paginatorInterface, Request $request, InterventionRepository $interventionRepository): Response
    {
        $user = $this->getUser();

        if (!is_null($user) && in_array('ROLE_MANAGER', $user->getRoles())) :
            if ($request->query->get('filterField') == 'client') {
                $jobsTechnicien = $paginatorInterface->paginate(
                    $interventionRepository->findInterventionByClientSearch(
                        $request->query->get('filterValue'),
                        $request->query->get('clos')
                    ),
                    $request->query->getInt('page', 1),
                    10
                );
            } elseif ($request->query->get('filterField') == 'technicien') {
                $jobsTechnicien = $paginatorInterface->paginate(
                    $interventionRepository->findInterventionByTechicienSearch(
                        $request->query->get('filterValue'),
                        $request->query->get('clos')
                    ),
                    $request->query->getInt('page', 1),
                    10
                );
            } elseif ($request->query->get('filterField') == 'materiel') {
                $jobsTechnicien = $paginatorInterface->paginate(
                    $interventionRepository->findInterventionByMaterielSearch(
                        $request->query->get('filterValue'),
                        $request->query->get('clos')
                    ),
                    $request->query->getInt('page', 1),
                    10
                );
            } else {
                $jobsTechnicien = $paginatorInterface->paginate(
                    $interventionRepository->findInterventionByTechicienSearch(
                        '',
                        $request->query->get('clos')
                    ),
                    $request->query->getInt('page', 1),
                    10
                );
            }


        else :
            $jobsTechnicien = $jobsTechnicien = $paginatorInterface->paginate(
                [],
                $request->query->getInt('page', 1),
                10
            );

        endif;

        return $this->render('technicien/jobs.html.twig', ['jobs' => $jobsTechnicien, 'titre_u' => 'Suivi des interventions']);
    }

    #[Route('/myjobs', name: 'myjobs')]
    public function myJobs(Request $request, PaginatorInterface $paginatorInterface, InterventionRepository $interventionRepository): Response
    {

        $myjobs = $paginatorInterface->paginate($interventionRepository->findBy(['technicien' => $this->getUser()]), $request->query->getInt('page', 1), 5);

        return $this->render('technicien/jobs.html.twig', ['jobs' => $myjobs, 'titre_u' => 'Mes interventions']);
    }


    #[Route('/jobs/{id}/edit', name: 'job_edit', methods: ['GET', 'POST'])]
    public function job_edit(Request $request, Intervention $intervention): Response
    {

        $form = $this->createForm(JobType::class, $intervention);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->flush();
            return $this->redirectToRoute('myjobs');
        }
        return $this->renderForm('technicien/job_edit.html.twig', ['form' => $form, 'intervention' => $intervention]);
    }

    #[Route('/profil', name: 'profil', methods: ['GET', 'POST'])]
    public function profil_edit(): Response
    {


        return $this->render('technicien/profil.html.twig', ['profil' => $this->getUser()]);
    }

    #[Route('/profil/update_password', name: 'update_password', methods: ['POST', 'GET'])]
    public function changePassword(Request $request, UserPasswordHasherInterface $userPasswordHasher): Response
    {

        $user = $this->getUser();


        $form = $this->createFormBuilder($user)
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'les mots de passe doivent être identique',
                'first_options' => [
                    'label' => 'Mot de passe',
                ],
                'second_options' => [
                    'label' => 'Confirmation mot de passe'
                ]
            ])
            ->add('submit', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) :
            $user->setPassword(
                $userPasswordHasher->hashPassword($user, $form['password']->getData())
            );
            $em = $this->getDoctrine()->getManager();
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Mot de passe mis à jour!');
            return $this->redirectToRoute('profil');
        endif;


        return $this->renderForm('technicien/update_password.html.twig', ['form' => $form]);
    }

    #[Route('/profil/edit', name: 'edit_profil', methods: ['GET', 'POST'])]
    public function editProfil(Request $request): Response
    {
        $user = $this->getUser();
        $formUser = $this->createFormBuilder($user, ['allow_extra_fields' => true])
            ->add('email', TextType::class)
            ->getForm();

        $formProfil = $this->createFormBuilder($user->getTechnicien(), ['allow_extra_fields' => true])
            ->add('nom', TextareaType::class)
            ->add('prenom', TextareaType::class)
            ->add('submit', SubmitType::class)
            ->getForm();

        $formUser->handleRequest($request);
        $formProfil->handleRequest($request);

        if ($formUser->isSubmitted() && $formUser->isValid() && $formProfil->isSubmitted() && $formProfil->isValid()) :
            $em = $this->getDoctrine()->getManager();
            $em->flush($user);
            $this->addFlash('success', 'Profil mis à jour');
            return $this->redirectToRoute('profil');
        endif;
        return $this->renderForm('technicien/edit_profil.html.twig', ['formUser' => $formUser, 'formProfil' => $formProfil]);
    }
}
