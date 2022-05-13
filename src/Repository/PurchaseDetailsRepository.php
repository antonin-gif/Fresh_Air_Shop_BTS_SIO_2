<?php

namespace App\Repository;

use App\Entity\PurchaseDetails;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\OptimisticLockException;
use Doctrine\ORM\ORMException;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<PurchaseDetails>
 *
 * @method PurchaseDetails|null find($id, $lockMode = null, $lockVersion = null)
 * @method PurchaseDetails|null findOneBy(array $criteria, array $orderBy = null)
 * @method PurchaseDetails[]    findAll()
 * @method PurchaseDetails[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PurchaseDetailsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PurchaseDetails::class);
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function add(PurchaseDetails $entity, bool $flush = true): void
    {
        $this->_em->persist($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }

    /**
     * @throws ORMException
     * @throws OptimisticLockException
     */
    public function remove(PurchaseDetails $entity, bool $flush = true): void
    {
        $this->_em->remove($entity);
        if ($flush) {
            $this->_em->flush();
        }
    }
}
