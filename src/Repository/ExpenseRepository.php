<?php

namespace App\Repository;

use App\Entity\Expense;
use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Symfony\Bridge\Doctrine\RegistryInterface;

class ExpenseRepository extends ServiceEntityRepository
{
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Expense::class);
    }

    public function findUserHighestExpense(User $user)
    {
        $query = $this->createQueryBuilder('e')
                      ->where('e.userId = :value')->setParameter('value', $user->getId())
                      ->orderBy('e.amount', 'DESC')
                      ->setMaxResults(1)
                      ->getQuery()
                      ->getResult();

        return $query ? $query[0]->getAmount() : 0;
    }

    public function findUserTotalExpense(User $user)
    {
        $query = $this->createQueryBuilder('e')
                      ->where('e.userId = :value')->setParameter('value', $user->getId())
                      ->select('SUM(e.amount) as total')
                      ->getQuery()
                      ->getResult();

        return $query ? $query[0]['total'] : 0;
    }

}
