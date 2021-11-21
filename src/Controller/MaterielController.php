<?php

namespace App\Controller;

use App\Entity\Materiel;
use App\Form\MaterielType;
use App\Repository\ClientRepository;
use App\Repository\MaterielRepository;
use App\Repository\MaterieltypeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


#[Route('/materiel')]
/**
 * @IsGranted("ROLE_MANAGER")
 */
class MaterielController extends AbstractController
{
    #[Route('/', name: 'materiel_index', methods: ['GET', 'POST'])]
    public function index(Request $request, MaterielRepository $materielRepository, PaginatorInterface $paginatorInterface): Response
    {
        $table = $request->query->get('filterField');
        $value = $request->query->get('filterValue');

        switch ($table) {
            case 'client':
                $datas = $materielRepository->findByClient($value);
                break;
            case 'categorie':
                $datas = $materielRepository->findByCategorie($value);
                break;

            case 'materiel':
                $datas = $materielRepository->findByMateriel($value);
                break;
            default:
                $datas = $materielRepository->findAll();
                break;
        }


        $paginator = $paginatorInterface->paginate(
            $datas,
            $request->query->getInt('page', 1),
            10
        );

        return $this->render('materiel/index.html.twig', [
            'materiels' => $paginator,
        ]);
    }

    #[Route('/new', name: 'materiel_new', methods: ['GET', 'POST'])]
    public function new(Request $request): Response
    {
        $materiel = new Materiel();
        $form = $this->createForm(MaterielType::class, $materiel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($materiel);
            $entityManager->flush();

            return $this->redirectToRoute('materiel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('materiel/new.html.twig', [
            'materiel' => $materiel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'materiel_show', methods: ['GET'])]
    public function show(Materiel $materiel): Response
    {
        return $this->render('materiel/show.html.twig', [
            'materiel' => $materiel,
        ]);
    }

    #[Route('/{id}/edit', name: 'materiel_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Materiel $materiel): Response
    {
        $form = $this->createForm(MaterielType::class, $materiel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('materiel_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('materiel/edit.html.twig', [
            'materiel' => $materiel,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'materiel_delete', methods: ['POST'])]
    public function delete(Request $request, Materiel $materiel): Response
    {
        if ($this->isCsrfTokenValid('delete' . $materiel->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($materiel);
            $entityManager->flush();
        }

        return $this->redirectToRoute('materiel_index', [], Response::HTTP_SEE_OTHER);
    }
}
