<?php

namespace App\Repository;

use App\Entity\Seat;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Seat|null find($id, $lockMode = null, $lockVersion = null)
 * @method Seat|null findOneBy(array $criteria, array $orderBy = null)
 * @method Seat[]    findAll()
 * @method Seat[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SeatRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Seat::class);
        $this->manager = $manager;
    }

    /**
     * @param Seat $entity
     * @return Seat
     */
    public function saveSeat(Seat $entity)
    {
        $this->manager->persist($entity);
        $this->manager->flush();

        return $entity;
    }

    /**
     * @param Seat $category
     * @return Seat
     */
    public function updateSeat(Seat $entity): Seat
    {
        $this->manager->persist($entity);
        $this->manager->flush();

        return $entity;
    }

    /**
     * @param Seat $category
     */
    public function removeSeat(Seat $entity)
    {
        $this->manager->remove($entity);
        $this->manager->flush();
    }
}
