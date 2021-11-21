<?php

namespace App\Controller;

use App\Entity\Technicien;
use App\Repository\UserRepository;
use App\Repository\ClientRepository;
use App\Repository\MaterielRepository;
use Doctrine\DBAL\Driver\IBMDB2\Result;
use App\Repository\TechnicienRepository;
use App\Repository\InterventionRepository;
use App\Repository\MaterieltypeRepository;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;

#[Route('/api')]
class ApiController extends AbstractController
{
    #[Route('/', name: 'api')]
    public function index(): Response
    {
        return $this->render('api/index.html.twig', [
            'controller_name' => 'ApiController',
        ]);
    }

    #[Route('/getTechnicien', name: "get_technicien")]
    public function getTechnicien(TechnicienRepository $technicienRepository, SerializerInterface $serializer, UserRepository $userRepository)
    {
        $technicien = new Technicien();
        $tab = array();
        $entity = $userRepository->findByRole('ROLE_TECHNICIEN');

        foreach ($entity as $data) {

            $tab[] = [
                'id' => $data->getId(),
                'nom' => $data->getTechnicien()->getNom(),
                'prenom' => $data->getTechnicien()->getPrenom(),
                'metier' => $data->getTechnicien()->getMetier()

            ];
        }
        /*   */
        $data = json_encode($tab, JSON_UNESCAPED_UNICODE);
        return new Response($data);
    }

    #[Route('/getClient', name: "getClient")]
    public function getClient(ClientRepository $clientRepository, MaterielRepository $materielRepository)
    {

        $clients = $clientRepository->findAll();

        $tab = array();
        foreach ($clients as $client) {
            $tab[] = [
                'id' => $client->getId(),
                'nom' => $client->getNom(),
                'prenom' => $client->getPrenom(),
                'societe' => $client->getSociete(),
                'adresse' => $client->getAdresse(),
                'codepostal' => $client->getCodepostal(),
                'ville' => $client->getVille(),
                'telephone' => $client->getTelephone(),
                'email' => $client->getMail(),
                'informations' => $client->getInformation(),

            ];
        }
        return new Response(json_encode($tab, JSON_UNESCAPED_UNICODE));
    }


    #[Route('/getMaterielById/{id}', name: "getMaterielByI", methods: ['get'])]
    public function getMaterielById(ClientRepository $clientRepository, $id)
    {

        $client = $clientRepository->find($id);

        $materielTab = array();
        foreach ($client->getMateriels() as $materiel) {
            $materielTab[] = [
                'id' => $materiel->getId(),
                'marque' => $materiel->getMaterielType()->getMarque(),
                'modele' => $materiel->getMaterielType()->getModele(),
                'matricule' => $materiel->getMatricule(),
                'compteur' => $materiel->getCompteur(),
                'categorie' => $materiel->getMaterielType()->getCategorie(),
                'information' => $materiel->getInfos(),
            ];
        }
        return new Response(json_encode($materielTab, JSON_UNESCAPED_UNICODE));
    }

    #[Route('/getMaterielsType', name: "getMaterielsType", methods: ['get'])]
    public function GetMaterielsType(MaterieltypeRepository $materielRepository)
    {
        $materielsType = $materielRepository->findAll();
        $materielsTypeTab = array();

        foreach ($materielsType as $materielType) {
            $materielsTypeTab[] =
                [
                    'id' => $materielType->getId(),
                    'marque' => $materielType->getMarque(),
                    'modele' => $materielType->getModele(),
                    'categorie' => $materielType->getCategorie(),
                ];
        };

        return new Response(json_encode($materielsTypeTab, JSON_UNESCAPED_UNICODE));
    }

    #[Route('/getMarqueByData/', name: 'getMarqueByData', methods: ['POST', 'GET'])]
    public function getMarquebyData(Request $request, MaterieltypeRepository $materielRepository): Response
    {
        $datas = $materielRepository->findByMarque($request->get('data'));
        $tab = array();
        foreach ($datas as $data) {
            if (!in_array($data->getMarque(), $tab)) {
                array_push($tab, $data->getMarque());
            }
        }

        return new Response(json_encode($tab, JSON_UNESCAPED_UNICODE));
    }
    #[Route('/getCategorieByData/', name: 'getCategoireByData', methods: ['GET'])]
    public function getCategorieByData(Request $request, MaterieltypeRepository $materielRepository): Response
    {
        $materielTypes = $materielRepository->findByCategorie($request->get('data'));
        $tab = array();
        foreach ($materielTypes as $materielType) {
            if (!in_array($materielType->getCategorie(), $tab)) {
                array_push($tab, $materielType->getCategorie());
            }
        }

        return new Response(json_encode($tab, JSON_UNESCAPED_UNICODE));
    }

    #[Route('/getMetierByData/', name: 'getMetierByData', methods: ['GET'])]
    public function getMetierByData(Request $request, TechnicienRepository $technicienRepository)
    {
        return new Response($technicienRepository->findByMetier($request->get('data')));
    }

    #[Route('/getMetier/', name: 'getMetier', methods: ['GET'])]
    public function getMetier(Request $request, TechnicienRepository $technicienRepository)
    {
        return new Response($technicienRepository->findMetierAll());
    }

    #[Route('/getClienByNom/', name: 'getClientByNom', methods: ['GET'])]
    public function getClientByNom(Request $request, ClientRepository $clientRepository)
    {
        return new Response($clientRepository->findBySearch($request->query->get('client')));
    }

    #[Route('/getMaterielByMarque/', name: 'getMaterielsByMarque', methods: ['GET'])]
    public function getMaterielByMarque(Request $request, MaterielRepository $materielRepository)
    {
        return new Response($materielRepository->findMarque($request->query->get('materiel')));
    }

    #[Route('/getCategoriesByNom/', name: 'getCategoriesByNom', methods: ['GET'])]
    public function getCategorieByNom(Request $request, MaterieltypeRepository $materielRepository)
    {
        return new Response($materielRepository->findCategorie($request->query->get('categorie')));
    }

    // Recherche interventions
    #[Route('/getInterventionsByClient', name: 'getIntervention')]
    public function getInterventionsByClient(Request $request, InterventionRepository $interventionRepository)
    {
        return new Response($interventionRepository->findInterventionByClient($request->query->get('client')));
    }

    #[Route('/getInterventionsByTechnicienSearch/', name: 'getInterventionByTechnicienSearch', methods: ['GET'])]
    public function getInterventionsByTechnicien(Request $request, InterventionRepository $interventionRepository)
    {
        return new Response($interventionRepository->findInterventionByTechicien(
            $request->query->get('technicien'),
            $request->query->get('clos')
        ));
    }
}
