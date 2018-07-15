<?php

namespace App\Repository;


use App\Entity\Photo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityNotFoundException;
use Ramsey\Uuid\UuidInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Photo|null find($id, $lockMode = null, $lockVersion = null)
 * @method Photo|null findOneBy(array $criteria, array $orderBy = null)
 * @method Photo[]    findAll()
 * @method Photo[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PhotoRepository extends ServiceEntityRepository
{


    /**
     * PhotoRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        parent::__construct($registry, Photo::class);
    }

    /**
     * @param Photo $photo
     * @param bool $state
     * @return void
     * @throws \Doctrine\ORM\ORMException
     */
    public function setPublished(Photo $photo, bool $state): void
    {
        $photo->setPublished($state);
        $this->getEntityManager()->flush();
    }

    /**
     * @return Photo[]
     */
    public function findAllPublished(): array
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.published = :published')
            ->setParameter('published', true)
            ->getQuery()
            ->getResult();
    }

    /**
     * @param string $id
     * @return Photo
     * @throws EntityNotFoundException
     */
    public function findOneById(string $id): Photo
    {
        if (null === ($photo = $this->find($id))) {
            throw new EntityNotFoundException("Photo with id: `$id` could not be found");
        }

        return $photo;
    }

    /**
     * @param string $fullPath
     * @return Photo|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function findOneByFullPath(string $fullPath): ?Photo
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.fullPath = :fullPath')
            ->setParameter('fullPath', $fullPath)
            ->getQuery()
            ->getOneOrNullResult();
    }

//    /**
//     * @return Photo[] Returns an array of Photo objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Photo
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
