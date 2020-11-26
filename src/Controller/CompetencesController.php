<?php

namespace App\Controller;

use App\Entity\Competences;
use App\Repository\CompetencesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class CompetencesController extends AbstractController
{

    private $competencesRepository,
        $serializer;

    private const ACCESS_DENIED = "Vous n'avez pas accés à cette ressource.",
        RESOURCE_NOT_FOUND = "Ressource inexistante.";

    public function __construct(CompetencesRepository $competencesRepository,SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
        $this->competencesRepository = $competencesRepository;
    }

/**
 * @Route(
 *     path="/api/admin/competences/{id<\d+>}",
 *     methods={"GET"},
 *     name="getCompetenceByID"
 * )
 */
    public function getCompetenceByID($id)
    {
        if(!$this->isGranted("VIEW",new Competences()))
        {
            return $this->json(["message" => self::ACCESS_DENIED],Response::HTTP_FORBIDDEN);
        }
        $competence = $this->competencesRepository->findOneBy(["id" => $id]);
        if ($competence && !$competence->getArchive()){
            $competence = $this->serializer->normalize($competence,null,["groups" => ['competence:read']]);
            return $this->json($competence,Response::HTTP_OK);
        }
        return $this->json(["message" => self::RESOURCE_NOT_FOUND],Response::HTTP_NOT_FOUND);
    }

/**
 * @Route(
 *     path="/api/admin/competences",
 *     methods={"GET"},
 *     name="getCompetences"
 * )
 */
    public function getCompetences()
    {
        if(!($this->isGranted("VIEW",new Competences())))
        {
            return $this->json(["message" => self::ACCESS_DENIED,Response::HTTP_FORBIDDEN]);
        }
        $competences = $this->competencesRepository->findBy(["archive" => false]);
        //dd($competences);
        $competences = $this->serializer->normalize($competences,null,["groups" => ['competences:read']]);
        return $this->json($competences,Response::HTTP_OK);
    }
}
