<?php

namespace App\Controller;

use App\Entity\Materieltype;
use App\Form\MaterieltypeType;
use App\Services\CheckFormFileHelper;

use App\Repository\MaterieltypeRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\FileUploadError;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;


#[Route('/materieltype')]
/**
 * @IsGranted("ROLE_MANAGER")
 */
class MaterieltypeController extends AbstractController
{
    #[Route('/', name: 'materieltype_index', methods: ['GET'])]
    public function index(PaginatorInterface $paginatorInterface, Request $request,  MaterieltypeRepository $materieltypeRepository): Response
    {
        $materielstype = $paginatorInterface->paginate($materieltypeRepository->findAll(), $request->query->getInt('page', 1), 10);
        return $this->render('materieltype/index.html.twig', [
            'materieltypes' => $materielstype,
        ]);
    }

    #[Route('/new', name: 'materieltype_new', methods: ['GET', 'POST'])]
    public function new(Request $request, CheckFormFileHelper $checkFormFileHelper): Response
    {
        $materieltype = new Materieltype();
        $form = $this->createForm(MaterieltypeType::class, $materieltype);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            //traitement fichier par injection d'un service
            $materieltype->setDocument($checkFormFileHelper->checkFile($form['document'], 'doc_service'));
            $materieltype->setPhoto($checkFormFileHelper->checkFile($form['photo'], 'photo_service'));

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($materieltype);
            $entityManager->flush();

            return $this->redirectToRoute('materieltype_show', ['id' => $materieltype->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('materieltype/new.html.twig', [
            'materieltype' => $materieltype,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'materieltype_show', methods: ['GET'])]
    public function show(Materieltype $materieltype): Response
    {
        return $this->render('materieltype/show.html.twig', [
            'materieltype' => $materieltype,
        ]);
    }

    #[Route('/{id}/edit', name: 'materieltype_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Materieltype $materieltype, CheckFormFileHelper $checkFormFileHelper): Response
    {
        $fileDoc = $this->getParameter('UPLOAD_DIR') . $materieltype->getDocument();
        $filePhoto = $this->getParameter(('UPLOAD_DIR')) . $materieltype->getPhoto();

        $form = $this->createForm(MaterieltypeType::class, $materieltype);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if (!is_null($form->get('photo')->getData())) :
                $materieltype->setPhoto(
                    $checkFormFileHelper->updateFile(
                        $filePhoto,
                        $form['photo'],
                        'photo'
                    )
                );
            else :
                $materieltype->setPhoto(basename($filePhoto));
            endif;
            if (!is_null($form->get('document')->getData())) :
                $materieltype->setDocument(
                    $checkFormFileHelper->updateFile(
                        $fileDoc,
                        $form['document'],
                        'doc'
                    )
                );
            else :
                $materieltype->setDocument(basename($fileDoc));
            endif;






            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('materieltype_show', ['id' => $materieltype->getId()], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('materieltype/edit.html.twig', [
            'materieltype' => $materieltype,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'materieltype_delete', methods: ['POST'])]
    public function delete(Request $request, Materieltype $materieltype, CheckFormFileHelper $checkFormFileHelper): Response
    {

        if ($this->isCsrfTokenValid('delete' . $materieltype->getId(), $request->request->get('_token'))) {

            $checkFormFileHelper->deleteFile($materieltype->getDocument());
            $checkFormFileHelper->deleteFile($materieltype->getPhoto());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($materieltype);
            $entityManager->flush();
        }

        return $this->redirectToRoute('materieltype_index', [], Response::HTTP_SEE_OTHER);
    }
}
