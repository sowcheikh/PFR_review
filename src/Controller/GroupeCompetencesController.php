<?php

namespace App\Controller;

use App\Entity\GroupeCompetences;
use App\Repository\GroupeCompetencesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class GroupeCompetencesController extends AbstractController
{
    private $groupeCompetenceRepository,
        $serializer;
    private const ACCESS_DENIED = "Vous n'avez pas access à cette Ressource",
        RESOURCE_NOT_FOUND = "Ressource inexistante",
        COMPETENCE_READ = "grpecompetence:competence:read";

    public function __construct(GroupeCompetencesRepository $groupeCompetencesRepository,SerializerInterface $serializer)
    {
        $this->groupeCompetenceRepository = $groupeCompetencesRepository;
        $this->serializer = $serializer;
    }

    /**
     * @Route(
     *     path="/api/admin/grpecompetences",
     *     methods={"GET"},
     *     name="getGroupeCompetences"
     * )
     */
    public function getGroupeCompetences()
    {
        if(!($this->isGranted("VIEW",new GroupeCompetences())))
        {
            return $this->json(["message" => self::ACCESS_DENIED],Response::HTTP_FORBIDDEN);
        }
        $groupeCompetences = $this->groupeCompetenceRepository->findBy(["archive" => false]);
        //dd($groupeCompetences);
        $groupeCompetences = $this->serializer->normalize($groupeCompetences,null,["groups" => ['grpecompetence:read_m']]);
        return $this->json($groupeCompetences,Response::HTTP_OK);
    }

    /**
     * @Route(
     *     path="/api/admin/grpecompetences/{id<\d+>}/competences",
     *     methods={"GET"},
     *     name="getCompetencesInGroupeCompetence"
     * )
     */
    public function getCompetencesInGroupeCompetence($id)
    {
        if(!($this->isGranted("VIEW",new GroupeCompetences())))
        {
            return $this->json(["message" => self::ACCESS_DENIED],Response::HTTP_FORBIDDEN);
        }
        $groupeCompetence = $this->groupeCompetenceRepository->findOneBy(["id" => $id]);
        if($groupeCompetence && !$groupeCompetence->getArchive())
        {
            $groupeCompetence = $this->serializer->normalize($groupeCompetence,null,["groups" => ['grpecompetence:competence:read']]);
            return $this->json($groupeCompetence,Response::HTTP_OK);
        }
        return $this->json(["message" => self::RESOURCE_NOT_FOUND],Response::HTTP_NOT_FOUND);
    }

}
