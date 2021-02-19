<?php

namespace App\Repository;

use App\Entity\Event;
use App\Entity\Schema;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Event|null find($id, $lockMode = null, $lockVersion = null)
 * @method Event|null findOneBy(array $criteria, array $orderBy = null)
 * @method Event[]    findAll()
 * @method Event[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Event::class);
        $this->manager = $manager;
    }

    /**
     * @param Event $event
     * @return Event
     */
    public function saveEvent(Event $event)
    {
        $this->manager->persist($event);
        $this->manager->flush();

        return $event;
    }

    /**
     * @param Event $event
     * @return Event
     */
    public function updateEvent(Event $event): Event
    {
        $this->manager->persist($event);
        $this->manager->flush();

        return $event;
    }

    /**
     * @param Event $event
     */
    public function removeEvent(Event $event)
    {
        $this->manager->remove($event);
        $this->manager->flush();
    }
}
