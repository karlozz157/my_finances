<?php

namespace MyFinancesBundle\Manager;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class CrudManager
{
    /**
     * @var EntityManager $entityManager
     */
    private $entityManager;

    /**
     * @var string $entityName
     */
    private $entityName;

    /**
     * @param EntityManager $entityManager
     * @param string        $entityName
     */
    public function __construct(EntityManager $entityManager, $entityName)
    {
        $this->entityManager = $entityManager;
        $this->entityName    = $entityName;
    }

    /**
     * @param int $id
     *
     * @return 
     */
    public function findById($id)
    {
        return $this->getRepository()->findOneBy(['id' => $id]);
    }

    /**
     * @return 
     */
    public function findAll()
    {
        return $this->getRepository()->findAll();
    }

    /**
     * @param $entity
     */
    public function persist($entity)
    {
        $this->entityManager->persist($entity);
        $this->entityManager->flush();
    }

    /**
     * @param $entity
     */
    public function remove($entity)
    {
        $this->entityManager->remove($entity);
        $this->entityManager->flush();
    }

    /**
     * @return EntityRepository
     */
    public function getRepository()
    {
        return $this->entityManager->getRepository($this->entityName);
    }
}
