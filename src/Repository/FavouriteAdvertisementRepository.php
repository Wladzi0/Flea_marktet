<?php

namespace App\Repository;

use App\Entity\FavouriteAdvertisement;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @method FavouriteAdvertisement|null find($id, $lockMode = null, $lockVersion = null)
 * @method FavouriteAdvertisement|null findOneBy(array $criteria, array $orderBy = null)
 * @method FavouriteAdvertisement[]    findAll()
 * @method FavouriteAdvertisement[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class FavouriteAdvertisementRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, FavouriteAdvertisement::class);
    }

    public function findAllFavouriteAdvertisementByUser($userId)
    {
            $query=$this->createQueryBuilder('f')
                ->where('f.user= :user')
                ->setParameter('user', $userId);
            return $query->getQuery()->getResult();
    }
}
