<?php

namespace App\Repository;

use App\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function findAllQuery($filterData = [])
    {
        $qb = $this->createQueryBuilder('p');

        if (!empty($filterData['search'])) {
            $qb
                ->andWhere('p.name LIKE :search OR p.info LIKE :search')
                ->setParameter('search', "%{$filterData['search']}%");
        }

        return $qb->getQuery();
    }

    public function search($filterData = [])
    {
        $qb = $this->createQueryBuilder('p');

        if (!empty($filterData['search'])) {
            $qb
                ->andWhere('p.name LIKE :search OR p.info LIKE :search')
                ->setParameter('search', "%{$filterData['search']}%");
        }

        return $qb->getQuery()->getResult();
    }
}