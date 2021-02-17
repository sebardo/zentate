<?php

namespace App\Repository;

use App\Entity\Category;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Category|null find($id, $lockMode = null, $lockVersion = null)
 * @method Category|null findOneBy(array $criteria, array $orderBy = null)
 * @method Category[]    findAll()
 * @method Category[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class CategoryRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Category::class);
        $this->manager = $manager;
    }

    /**
     * @param Category $entity
     * @return Category
     */
    public function saveCategory(Category $entity)
    {
        $this->manager->persist($entity);
        $this->manager->flush();

        return $entity;
    }

    /**
     * @param Category $category
     * @return Category
     */
    public function updateCategory(Category $category): Category
    {
        $this->manager->persist($category);
        $this->manager->flush();

        return $category;
    }

    /**
     * @param Category $category
     */
    public function removeCategory(Category $category)
    {
        $this->manager->remove($category);
        $this->manager->flush();
    }
}
