<?php

namespace App\Repository;

use App\Entity\Advertisement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method Advertisement|null find($id, $lockMode = null, $lockVersion = null)
 * @method Advertisement|null findOneBy(array $criteria, array $orderBy = null)
 * @method Advertisement[]    findAll()
 * @method Advertisement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class AdvertisementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Advertisement::class);
    }

    public function findAdvertisementsByLocation($location)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT a
                FROM App\Entity\Advertisement a
                WHERE a.location LIKE :location'
            )
            ->setParameter('location', '%' . $location . '%')
            ->setMaxResults(20)
            ->getResult();
    }
    public function findAdvertisementsByString($str)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT a
                FROM App\Entity\Advertisement a
                WHERE a.name LIKE :str OR a.description LIKE :str'
            )
            ->setParameter('str', '%'.$str.'%')
            ->getResult();
    }
    public function findEntityByString($chars)
    {
        return $this->getEntityManager()
            ->createQuery(
                'SELECT a
                FROM App\Entity\Advertisement a
                WHERE a.name LIKE :chars'
//                 WHERE a.name LIKE :chars OR a.description LIKE :chars'
            )
            ->setParameter('chars', '%' . $chars . '%')
            ->setMaxResults(20)
            ->getResult();

    }

    public function findPostBySubcategory($subCategory)
    {
        $query = $this->createQueryBuilder('a')
            ->where('a.subcategory = :subcategory')
            ->setParameter('subcategory', $subCategory);
        return $query->getQuery()->getResult();
    }

    public function findAdvertisements()
    {
        $query=$this->createQueryBuilder('a')
            ->orderBy('a.updatedAt', 'DESC');
        return $query->getQuery()->getResult();
    }

    public function findAllUserAdv($user)
    {
        $query=$this->createQueryBuilder('a')
            ->where('a.user = :user')
            ->setParameter('user', $user);
        return $query->getQuery()->getResult();
    }
}
