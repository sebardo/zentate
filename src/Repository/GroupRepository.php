<?php

namespace App\Repository;

use App\Entity\Group;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Group|null find($id, $lockMode = null, $lockVersion = null)
 * @method Group|null findOneBy(array $criteria, array $orderBy = null)
 * @method Group[]    findAll()
 * @method Group[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class GroupRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Group::class);
        $this->manager = $manager;
    }

    /**
     * @param Group $entity
     * @return Group
     */
    public function saveGroup(Group $entity)
    {
        $this->manager->persist($entity);
        $this->manager->flush();

        return $entity;
    }

    /**
     * @param Group $group
     * @return Group
     */
    public function updateGroup(Group $group): Group
    {
        $this->manager->persist($group);
        $this->manager->flush();

        return $group;
    }

    /**
     * @param Group $group
     */
    public function removeGroup(Group $group)
    {
        $this->manager->remove($group);
        $this->manager->flush();
    }
}
