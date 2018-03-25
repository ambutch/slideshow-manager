<?php

namespace App\Repository;


use App\Entity\Directory;
use App\Entity\Photo;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
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
     * @return null|string
     * @throws \Doctrine\ORM\ORMInvalidArgumentException
     */
    public function setPublished(Photo $photo, bool $state): ?string
    {
        if($state) {
            /** @var DirectoryRepository $directoryRepo */
            $directoryRepo = $this->getEntityManager()->getRepository(Directory::class);
            $path = $directoryRepo->getNamePath($photo->getParent()) . $photo->getBaseName();
        } else {
            $path = null;
        }
        $photo->setPublished($path);
        return $path;
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