<?php


namespace App\DataPersister;

use App\Entity\Profil;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 *
 */
class ProfilDataPersister implements ContextAwareDataPersisterInterface
{
    private $_entityManager;
    private $_passwordEncoder;

    public function __construct(
        EntityManagerInterface $entityManager,
        UserPasswordEncoderInterface $passwordEncoder
    ) {
        $this->_entityManager = $entityManager;
        $this->_passwordEncoder = $passwordEncoder;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Profil;
    }

    /**
     * @param Profil $data
     */
    public function persist($data, array $context = [])
    {
       return $data;
    }

    /**
     * {@inheritdoc}
     */
    public function remove($data, array $context = [])
    {

        $data->setArchive(1);
        $usersArchive = $data->getUsers();
        foreach($usersArchive as $value) {
            $value->setArchive(1);
            $this->_entityManager->persist($value);
        }
        $this->_entityManager->flush();
    }
}
