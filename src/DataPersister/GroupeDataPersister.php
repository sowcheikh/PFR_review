<?php

namespace App\DataPersister;

use App\Entity\Groupe;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 *
 */
class GroupeDataPersister implements ContextAwareDataPersisterInterface
{
    private $_entityManager;

    public function __construct(
        EntityManagerInterface $entityManager
    )
    {
        $this->_entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Groupe;
    }

    /**
     * @param Groupe $data
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
        $grpArchive = $data->getApprenant();
        foreach($grpArchive as $value) {
            $value->setArchive(1);
            $this->_entityManager->persist($value);
        }
        $this->_entityManager->flush();
    }
}
