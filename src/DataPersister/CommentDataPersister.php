<?php

namespace App\DataPersister;

use ApiPlatform\Core\DataPersister\ContextAwareDataPersisterInterface;
use App\Entity\Comment;
use DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

class CommentDataPersister implements ContextAwareDataPersisterInterface
{
    public function __construct(private EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    
    public function supports($data, array $context = []): bool
    {
        return $data instanceof Comment;
    }

    
    public function persist($data, array $context = [])
    {
        if(!$data->getId()){
            $data->setCreatedAt(new DateTimeImmutable());
        }
        $this->entityManager->persist($data);
        $this->entityManager->flush($data);
    }

    
    public function remove($data, array $context = [])
    {
        $this->entityManager->remove($data);
        $this->entityManager->flush();
    }
}