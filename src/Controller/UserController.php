<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\ProfilRepository;
use App\Repository\UserRepository;
use App\Services\UpdateUserService;
use App\Services\UploadFile;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{
    /**
     * @Route(
     *     path="/api/admin/users",
     *     methods={"POST"},
     *     defaults={
     *          "__controller"="App\Controller\UserController::addUsers",
     *          "__api_resource_class"=User::class,
     *          "__api_collection_operation_name"="add_users"
     *     }
     * )
     */
    public function addUsers(Request $request,UserPasswordEncoderInterface $encoder,SerializerInterface $serializer,
                             ValidatorInterface $validator,ProfilRepository $profil,EntityManagerInterface $manager, UploadFile $file)
    {
        $user = $request->request->all();
        //dd($user);
        $avatar = $file::uploadFile($request->files->get("avatar"));
        $user["avatar"] = $avatar;
        $profilUser = $profil->find($user['profile']);
        if ($profilUser) {
            unset($user["profile"]);
            if ($profilUser->getLibelle()=='FORMATEUR') {
                $user = $serializer->denormalize($user,"App\Entity\Formateur");
            } elseif ($profilUser->getLibelle()=='CM') {
                $user = $serializer->denormalize($user,"App\Entity\CM");
            } elseif ($profilUser->getLibelle()=='APPRENANT') {
                $user = $serializer->denormalize($user,"App\Entity\Apprenant");
            } else {
                $user = $serializer->denormalize($user, "App\Entity\User");
            }
        }

        //dd($user);
        $errors = $validator->validate($user);
        if (count($errors)){
            $errors = $serializer->serialize($errors,"json");
            return new JsonResponse($errors,Response::HTTP_BAD_REQUEST,[],true);
        }
        $user->setPassword($encoder->encodePassword($user,'passer'));
        $user->setProfile($profilUser);
        $manager->persist($user);
        $manager->flush();
        fclose($avatar);
        return $this->json($user,Response::HTTP_CREATED);
    }


    /**
     * @Route(
     *     path="/api/admin/users/{id}",
     *     methods={"PUT"},
     *     defaults={
     *          "__api_resource_class"=User::class,
     *          "__api_item_operation_name"="update_users"
     *     }
     * )
     * @param $id
     * @param Request $request
     * @param UserPasswordEncoderInterface $encoder
     * @param SerializerInterface $serializer
     * @param ValidatorInterface $validator
     * @param UserRepository $repository
     * @param ProfilRepository $profilRepository
     * @param EntityManagerInterface $manager
     * @param UpdateUserService $updateUser
     * @return JsonResponse
     */
    public function updateUsers($id, Request $request, UserPasswordEncoderInterface $encoder, SerializerInterface $serializer,
                                ValidatorInterface $validator, UserRepository $repository, ProfilRepository $profilRepository, EntityManagerInterface $manager, UpdateUserService $updateUser, UploadFile $file)
    {
        $data = $updateUser->PutUser($request, 'avatar', $profilRepository);
        $user =$repository->find($id);
            foreach ($data as $key => $value) {
                $donne = 'set'.ucfirst($key);
                if (method_exists(User::class, $donne)) {
                    if ($key=='profile') {
                        $profileID = $data[$key];
                        $profile = $profilRepository->findOneBy(['id' => $profileID]);
                        $user->$donne($profile);
                    } else {
                        $user->$donne($value);
                    }
                }

            }
        $errors = $validator->validate($user);
        if (count($errors)){
            $errors = $serializer->serialize($errors,"json");
            return new JsonResponse($errors,Response::HTTP_BAD_REQUEST,[],true);
        }
        $user->setPassword($encoder->encodePassword($user, $user->getPassword()));
        $user->setProfile($profile);
        $manager->persist($user);
        $manager->flush();

        return $this->json($user);
    }
}
