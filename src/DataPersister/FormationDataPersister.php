<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Formation;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

class FormationDataPersister implements ContextAwareDataPersisterInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Formation;
    }

    
    public function persist($data, array $context = [])
    {
        if(!$data->getId()){
            $data->setCreatedAt(new \DateTimeImmutable());
        }
        $data->setUpdatedAt(new \DateTimeImmutable());

        $this->entityManager->persist($data);
        $this->entityManager->flush();
    }

    
    public function remove($data, array $context = [])
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}