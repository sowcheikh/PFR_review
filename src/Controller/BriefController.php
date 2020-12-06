<?php

namespace App\Controller;

use App\Entity\Brief;
use App\Repository\BriefRepository;
use App\Repository\FormateurRepository;
use App\Repository\GroupeRepository;
use App\Repository\PromoRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BriefController extends AbstractController
{
    private $briefRepository;
    private $promoRepository;
    private $formateurRepository;
    private $groupeRepository;

    private const ACCESS_DENIED = "Vous n'avez pas accés à cette ressource.",
        RESOURCE_NOT_FOUND = "Ressource inexistante.",
        BRIEF_READ = "getBriefs:read";

    public function __construct(BriefRepository $briefRepository, PromoRepository $promoRepository,
                                FormateurRepository $formateurRepository, GroupeRepository $groupeRepository)
    {
        $this->briefRepository = $briefRepository;
        $this->formateurRepository = $formateurRepository;
        $this->promoRepository = $promoRepository;
        $this->groupeRepository = $groupeRepository;
    }

    /**
     * @Route("/api/formateurs/{id<\d+>}/briefs/brouillons",name="getBriefBrouillonByFormateur",methods={"GET"})
     */
    public function getBriefBrouillonByFormateur($id)
    {
        $brief = new Brief();
        if (!$this->isGranted("VIEW",$brief))
        {
            return $this->json(["message" => "Vous n'avez pas accés à cette ressource"],Response::HTTP_FORBIDDEN);
        }
        $formateur = $this->formateurRepository->findOneBy(["id" => $id]);
        if($formateur && !$formateur->getArchive())
        {
            foreach ($formateur->getBriefs() as $brief) {
                //dd($brief);
                if ($brief->getEtat() != 'brouillon') {
                    $formateur->removeBrief($brief);
                }
            }
            return $this->json($formateur->getBriefs(),Response::HTTP_OK, [], ['groups'=> ['briefBrVal:read']]) ;

        }

        return $this->json(["message" => "ressource inexistante."],Response::HTTP_NOT_FOUND);
    }

    /**
     * @Route("/api/formateurs/{id<\d+>}/briefs/valide",name="getBriefValidByFormateur",methods={"GET"})
     */
    public function getBriefValidByFormateur($id)
    {
        $brief = new Brief();
        //dd($brief);
        if (!$this->isGranted("VIEW",$brief))
        {
            return $this->json(["message" => "Vous n'avez pas accés à cette ressource"],Response::HTTP_FORBIDDEN);
        }

        $formateur = $this->formateurRepository->findOneBy(["id" => $id]);
        if($formateur && !$formateur->getArchive())
        {
            foreach ($formateur->getBriefs() as $brief) {
                if ($brief->getEtat() != 'valide') {
                    $formateur->removeBrief($brief);
                }
            }
            return $this->json($formateur->getBriefs(),Response::HTTP_OK, [], ['groups'=> ['briefBrVal:read']]) ;

        }

        //dd($brief);
        return $this->json(["message" => "ressource inexistante."],Response::HTTP_NOT_FOUND);
    }

    /**
     * @Route("/api/formateurs/promos/{idPromo}/groupes/{idGroup}/briefs",name="getBriefsInGroupe",methods={"GET"})
     */

    public function getBriefsInGroupe ($idGroup, $idPromo) {
        if(!$this->isGranted("VIEW",new Brief()))
        {
            return $this->json(["message" => self::ACCESS_DENIED],Response::HTTP_FORBIDDEN);
        }
        $promo = $this->promoRepository->findOneBy(["id" => (int)$idPromo]);
        if ($promo && !$promo->getArchive())
        {
            $groupe = $this->groupeRepository->findOneBy(["id" => (int)$idGroup]);
            $message = '';
            $status = null;
            if ($groupe)
            {
                $groupesInPromo = $promo->getGroupes()->getValues();
                if (in_array($groupe,$groupesInPromo))
                {
                    return $groupe->getBrief();
                }
                else{
                    $message = "Ce groupe n'est pas dans cette promo.";
                    $status = Response::HTTP_NOT_FOUND;
                }
            }
            else{
                $message = "Ce groupe est introuvable .";
                $status = Response::HTTP_NOT_FOUND;
            }
            return $this->json(["message" => $message],$status);
        }
        return  $this->json(["message" => self::RESOURCE_NOT_FOUND],Response::HTTP_NOT_FOUND);
    }

    /**
     * @Route("/api/formateurs/promos/{idPromo}/briefs/{idBrief}",name="getBriefInPromo",methods={"GET"})
     */

    public function getBriefInPromo ($idBrief, $idPromo) {
        if (!$this->isGranted("VIEW",new Brief()))
        {
            return $this->json(["message" => self::ACCESS_DENIED],Response::HTTP_FORBIDDEN);
        }
        $promo = $this->promoRepository->findOneBy(["id" => (int)$idPromo]);
        if($promo && !$promo->getArchive())
        {
            $brief = $this->briefRepository->findOneBy(["id" => (int)$idBrief]);
            if ($brief)
            {
                $promoBriefs = $brief->getPromoBriefs();
                foreach ($promoBriefs as $promoBrief)
                {
                    if ($promoBrief->getBrief() === $brief)
                    {
                        return $brief;
                    }
                }
            }
        }
        return  $this->json(["message" => self::RESOURCE_NOT_FOUND],Response::HTTP_NOT_FOUND);
    }

    /**
     * @Route(
     *     path="/api/apprenants/promos/{id<\d+>}/briefs",
     *     methods={"GET"},
     *     name="getBriefsApprenant",
     *     defaults={
     *          "_controller"="\App\Controller\BriefController::getBriefsApprenant",
     *          "_api_resource_class"=Brief::class,
     *          "_api_collection_operation_name"="getBriefsApprenant"
     *      }
     * )
     */
    public function getBriefsApprenant($id)
    {
        if(!$this->isGranted("VIEW",new Brief()))
        {
            return $this->json(["message" => self::ACCESS_DENIED],Response::HTTP_FORBIDDEN);
        }
        $promo = $this->promoRepository->findOneBy(["id" => (int)$id]);
        if ($promo && !$promo->getArchive())
        {
            $briefAssigneApprenants = [];
            $promoBriefs = $promo->getPromoBriefs();
            foreach ($promoBriefs as $promoBrief)
            {
                $brief = $promoBrief->getBrief();
                if($brief->getStatusBrief() == "assigne")
                {
                    $briefAssigneApprenants[] = $brief;
                }
            }
            return $briefAssigneApprenants;
        }
        return  $this->json(["message" => self::RESOURCE_NOT_FOUND],Response::HTTP_NOT_FOUND);
    }
}
