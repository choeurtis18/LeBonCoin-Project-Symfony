<?php

namespace App\Repository;

use App\Entity\Annonce;
use App\Entity\Photo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Photo>
 *
 * @method Photo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Photo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Photo[]    findAll()
 * @method Photo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotoRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Photo::class);
    }

    public function save(Photo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Photo $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

//    /**
//     * @return Photo[] Returns an array of Photo objects
//     */
//    public function findByImages($value): array
//    {
//        return $this->createQueryBuilder('p')
//        ->innerJoin(Photo::class, 'p')
//        ->where('p.IdAnnonce = ' .$value)
//        ->getQuery()
//        ->getResult()
//        ;
//    }

/**
    * @return Photo[] Returns an array of Question objects
*/
public function findByImages($value): array
{
    return $this->createQueryBuilder('p')
     ->innerJoin(Annonce::class, 'a')
     ->where('p.IdAnnonce = ' .$value)
     ->getQuery()
     ->getResult()
    ;
}

//    public function findOneBySomeField($value): ?Photo
//    {
//        return $this->createQueryBuilder('p')
//            ->andWhere('p.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
