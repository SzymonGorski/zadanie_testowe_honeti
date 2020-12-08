<?php

namespace App\Repository;

use App\Entity\Person;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class PersonRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Person::class);
    }

    public function findAllQuery($filterData = [])
    {
        $qb = $this->createQueryBuilder('p');

        if (!empty($filterData['state'])) {
            $qb
                ->andWhere('p.state = :state')
                ->setParameter('state', $filterData['state']);
        }

        if (!empty($filterData['search'])) {
            $qb
                ->andWhere('p.login LIKE :search OR p.firstname LIKE :search OR p.lastname LIKE :search')
                ->setParameter('search', "%{$filterData['search']}%");
        }

        return $qb->getQuery();
    }

    public function search($filterData = [])
    {
        $qb = $this->createQueryBuilder('p');

        if (!empty($filterData['search'])) {
            $qb
                ->andWhere('p.login LIKE :search')
                ->setParameter('search', "%{$filterData['search']}%");
        }

        return $qb->getQuery()->getResult();
    }
}