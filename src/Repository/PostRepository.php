<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

class PostRepository extends EntityRepository
{
    public function getPostsByTagId($id)
    {
        $qb = $this->createQueryBuilder('p')
            ->join('p.tags', 't')
            ->where('t.id = :id')
            ->setParameter('id', $id)
            ->getQuery();
        return $qb->execute();
    }
}