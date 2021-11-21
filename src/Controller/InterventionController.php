<?php

namespace App\Controller;

use DateTime;
use App\Entity\Intervention;
use App\Form\InterventionType;
use App\Repository\InterventionRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


/**
 * @IsGranted("ROLE_MANAGER")
 */
#[Route('/intervention')]
class InterventionController extends AbstractController
{
    #[Route('/', name: 'intervention_index', methods: ['GET'])]
    public function index(Request $request, InterventionRepository $interventionRepository, PaginatorInterface $paginatorInterface): Response
    {
        $interventions = $paginatorInterface->paginate(
            $interventionRepository->findAll(),
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('intervention/index.html.twig', [
            'interventions' => $interventions,
        ]);
    }

    #[Route('/new', name: 'intervention_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $intervention = new Intervention();
        $intervention->setStatus(False);


        $form = $this->createForm(InterventionType::class, $intervention);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($intervention);
            $entityManager->flush();

            return $this->redirectToRoute('intervention_show', ['id' => $intervention->getId()], Response::HTTP_SEE_OTHER);
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('error', 'Des erreurs sont présentes dans le formulaire');
        }

        return $this->renderForm('intervention/new.html.twig', [
            'intervention' => $intervention,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'intervention_show', methods: ['GET'])]
    public function show(Intervention $intervention): Response
    {
        return $this->render('intervention/show.html.twig', [
            'intervention' => $intervention,
        ]);
    }

    #[Route('/{id}/edit', name: 'intervention_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Intervention $intervention): Response
    {
        $form = $this->createForm(InterventionType::class, $intervention);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();
            $this->addFlash('success', 'Mise à jour réussie!');


            return $this->redirectToRoute('intervention_show', ['id' => $intervention->getId()], Response::HTTP_SEE_OTHER);
        }

        if ($form->isSubmitted() && !$form->isValid()) {
            $this->addFlash('error', 'Des erreurs sont présentes dans le formulaire');
        }

        return $this->renderForm('intervention/edit.html.twig', [
            'intervention' => $intervention,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'intervention_delete', methods: ['POST'])]
    public function delete(Request $request, Intervention $intervention): Response
    {
        if ($this->isCsrfTokenValid('delete' . $intervention->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($intervention);
            $entityManager->flush();
        }

        return $this->redirectToRoute('intervention_index', [], Response::HTTP_SEE_OTHER);
    }
}
