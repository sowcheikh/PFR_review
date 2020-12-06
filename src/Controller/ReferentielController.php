<?php

namespace App\Controller;

use App\Repository\GroupeCompetencesRepository;
use App\Repository\ReferentielRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ReferentielController extends AbstractController
{
    private $referentielRepository;
    private $groupeCompetencesRepository;
    public function __construct(ReferentielRepository $referentielRepository, GroupeCompetencesRepository $groupeCompetencesRepository)
    {
        $this->referentielRepository = $referentielRepository;
        $this->groupeCompetencesRepository = $groupeCompetencesRepository;
    }

    /**
     * @Route("/api/admin/referentiels/{id_1}/grpcompetences/{id_2}",name="getCompInGrpInRefs",methods={"GET"})
     */
    public function getCompInGrpInRefs($id_1, $id_2)
    {
       $val1 = $this->referentielRepository->find($id_1);
       $val2 = $this->groupeCompetencesRepository->find($id_2);
       //dd($val2);
       $data=$this->referentielRepository->findGroupCompetence($val1->getId(), $val2->getId());
       //dd($data);
       return $this->json($data, Response::HTTP_OK, [], ['groups'=> ['ref_c_grp:read']]);
    }
}
