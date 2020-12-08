<?php

namespace App\Repository;

use App\Entity\PersonLikeProduct;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PersonLikeProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, PersonLikeProduct::class);
    }

    public function findAllQuery($filterData = [])
    {
        $qb = $this->createQueryBuilder('plp');

        if(!empty($filterData['person'])){
            $qb
                ->andWhere('plp.person = :person')
                ->setParameter('person', $filterData['person']);
        }

        if(!empty($filterData['product'])){
            $qb
                ->andWhere('plp.product = :product')
                ->setParameter('product', $filterData['product']);
        }

        return $qb->getQuery()->getResult();
    }
}