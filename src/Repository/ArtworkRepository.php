<?php

namespace App\Repository;

use App\Entity\Artwork; 
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository; 
use Doctrine\Common\Collections\Collection;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends ServiceEntityRepository<Artwork>
 *
 * @method Artwork|null find($id, $lockMode = null, $lockVersion = null)
 * @method Artwork|null findOneBy(array $criteria, array $orderBy = null)
 * @method Artwork[]    findAll()
 * @method Artwork[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Artwork[]    findByCategory(array $category)
 */
class ArtworkRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Artwork::class);
    }

    public function save(Artwork $entity, bool $flush = false): void
    {
        $this->getEntityManager()->persist($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    }

    public function remove(Artwork $entity, bool $flush = false): void
    {
        $this->getEntityManager()->remove($entity);

        if ($flush) {
            $this->getEntityManager()->flush();
        }
    } 

    /**
     * @return Artwork[]
     */
    public function findByCategory(Collection $Category) 
    {
        $qb = $this->createQueryBuilder("c")
            ->where(':Category MEMBER OF c.Category')
            ->setParameters(array('Category' => $Category))
        ;
        // $entityManager = $this->getEntityManager();
        return $qb->getQuery()->getResult();
    } 
    
//    /**
//     * @return Artwork[] Returns an array of Artwork objects
//     */
//    public function findByExampleField($value): array
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->orderBy('a.id', 'ASC')
//            ->setMaxResults(10)
//            ->getQuery()
//            ->getResult()
//        ;
//    }

//    public function findOneBySomeField($value): ?Artwork
//    {
//        return $this->createQueryBuilder('a')
//            ->andWhere('a.exampleField = :val')
//            ->setParameter('val', $value)
//            ->getQuery()
//            ->getOneOrNullResult()
//        ;
//    }
}
