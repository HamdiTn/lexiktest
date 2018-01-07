<?php

namespace lexiktestBundle\Repository;

class UsersRepository extends \Doctrine\ORM\EntityRepository
{
    public function findAllOrderByGroup()
    {
        $query = $this->createQueryBuilder('users');
        $query->join('users.groups', 'group');
        $query->orderBy('group.name');

        return $query->getQuery()->getResult();
    }

    public function findByName($name)
    {
        $query = $this->createQueryBuilder('users');
        $query->innerJoin('users.groups', 'groups');
        $query->where('users.name = :name')
        ->orWhere('groups.name = :name')
        ->setParameter('name', $name);

        return $query->getQuery()->getResult();
    }
}
