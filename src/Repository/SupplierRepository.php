<?php

namespace App\Repository;

use App\Entity\Supplier;
use App\Pagination\Paginator;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Supplier|null find($id, $lockMode = null, $lockVersion = null)
 * @method Supplier|null findOneBy(array $criteria, array $orderBy = null)
 * @method Supplier[]    findAll()
 * @method Supplier[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SupplierRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Supplier::class);
    }

    /**
     * Our findLatest() method
     *
     * 1. Create & pass query to paginate method
     * 2. Paginate will return a `App\Pagination\Paginator` object
     * 3. Return that object to the controller
     *
     * @param integer $page The current page (passed from controller)
     *
     * @return \App\Pagination\Paginator;
     */
    public function findLatest(int $page = 1): Paginator
    {
        $qb = $this->createQueryBuilder('p')
           ->orderBy('p.id', 'DESC')
        ;      

        return (new Paginator($qb))->paginate($page);
    }

    // /**
    //  * @return Supplier[] Returns an array of Supplier objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('s.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Supplier
    {
        return $this->createQueryBuilder('s')
            ->andWhere('s.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
