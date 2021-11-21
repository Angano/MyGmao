<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\UserType;
use App\Entity\Technicien;
use App\Form\TechnicienType;
use App\Repository\UserRepository;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\EventListener\IsGrantedListener;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Http\Authenticator\Passport\UserPassportInterface;


#[Route('/user')]
/**
 * @IsGranted("ROLE_ADMIN")
 */
class UserController extends AbstractController
{
    #[Route('/', name: 'user_index', methods: ['GET'])]
    public function index(UserRepository $userRepository): Response
    {
        return $this->render('user/index.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'user_new', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_ADMIN')]
    public function new(Request $request, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        $user = new User();
        $technicien = new Technicien();
        $form = $this->createForm(UserType::class, $user);

        $formProfil = $this->createForm(TechnicienType::class, $technicien);
        $form->handleRequest($request);
        $formProfil->handleRequest($request);

        if ($form->isSubmitted() && $formProfil->isSubmitted() && $formProfil->isValid() && $form->isValid()) {
            $user->setPassword(
                $userPasswordHasherInterface->hashPassword($user, $form->get('password')->getData())
            );
            $entityManager = $this->getDoctrine()->getManager();

            $user->setTechnicien($technicien);
            $entityManager->persist($user);
            $entityManager->persist($technicien);
            $entityManager->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/new.html.twig', [
            'user' => $user,
            'form' => $form,
            'formprofil' => $formProfil,
        ]);
    }

    #[Route('/{id}', name: 'user_show', methods: ['GET'])]
    public function show(User $user): Response
    {
        return $this->render('user/show.html.twig', [
            'user' => $user,
        ]);
    }

    #[Route('/{id}/edit', name: 'user_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, User $user, UserPasswordHasherInterface $userPasswordHasherInterface): Response
    {
        //$form = $this->createForm(UserType::class, $user);
        $form = $this->createFormBuilder($user)
            ->add('email', TextType::class)
            ->add(
                'roles',
                ChoiceType::class,
                [
                    'choices'  => [
                        'User' => 'ROLE_USER',
                        'Technicien'    => 'ROLE_TECHNICIEN',
                        'Secretaire'    => 'ROLE_SECRETAIRE',
                        'Manager' => 'ROLE_MANAGER',
                        'Admin'     => 'ROLE_ADMIN',
                        'Super admin'    => 'ROLE_SUPER_ADMIN',
                    ],
                    'multiple' => true,
                ]
            )
            ->add('submit', SubmitType::class)
            ->getForm();
        $form->handleRequest($request);

        $technicien = $user->getTechnicien() ?? new Technicien();
        $formProfil = $this->createForm(TechnicienType::class, $technicien);
        $formProfil->handleRequest($request);

        if ($form->isSubmitted() && $formProfil->isSubmitted() && $formProfil->isValid() && $form->isValid()) {

            //$user->setPassword($userPasswordHasherInterface->hashPassword($user, $form->get('password')->getData()));
            $user->setTechnicien($technicien);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('user/edit.html.twig', [
            'user' => $user,
            'form' => $form,
            'formprofil' => $formProfil
        ]);
    }

    #[Route('/{id}', name: 'user_delete', methods: ['POST'])]
    public function delete(Request $request, User $user): Response
    {
        if ($this->isCsrfTokenValid('delete' . $user->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($user);
            $entityManager->flush();
        }

        return $this->redirectToRoute('user_index', [], Response::HTTP_SEE_OTHER);
    }
}
