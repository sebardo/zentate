<?php

namespace App\Repository;

use App\Entity\Schema;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Schema|null find($id, $lockMode = null, $lockVersion = null)
 * @method Schema|null findOneBy(array $criteria, array $orderBy = null)
 * @method Schema[]    findAll()
 * @method Schema[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class SchemaRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Schema::class);
        $this->manager = $manager;
    }

    /**
     * @param Schema $entity
     * @return Schema
     */
    public function saveSchema(Schema $entity)
    {
        $this->manager->persist($entity);
        $this->manager->flush();

        return $entity;
    }

    /**
     * @param Schema $schema
     * @return Schema
     */
    public function updateSchema(Schema $schema): Schema
    {
        $this->manager->persist($schema);
        $this->manager->flush();

        return $schema;
    }

    /**
     * @param Schema $schema
     */
    public function removeSchema(Schema $schema)
    {
        $this->manager->remove($schema);
        $this->manager->flush();
    }
}
