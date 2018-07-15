<?php

namespace App\Repository;


use App\Entity\Directory;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepositoryInterface;
use Doctrine\ORM\EntityNotFoundException;
use Gedmo\Tree\Entity\Repository\NestedTreeRepository;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Bridge\Doctrine\RegistryInterface;

/**
 * @method Directory|null   find($id, $lockMode = null, $lockVersion = null)
 * @method Directory|null   findOneBy(array $criteria, array $orderBy = null)
 * @method Directory[]      findAll()
 * @method Directory[]      findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 * @method Directory[]      getRootNodes($sortByField = null, $direction = 'ASC')
 * @method array            getNodesHierarchy($node = null, $direct = false, array $options = [], $includeNode = false)
 * @method Directory[]|null getChildren($node = null, $direct = false, $sortByField = null, $direction = 'ASC', $includeNode = false);
 * @method int              childCount($node = null, $direct = false);
 */
class DirectoryRepository extends NestedTreeRepository implements ServiceEntityRepositoryInterface
{
    /**
     * DirectoryRepository constructor.
     * @param RegistryInterface $registry
     */
    public function __construct(RegistryInterface $registry)
    {
        $manager = $registry->getEntityManager();
        parent::__construct($manager, $manager->getClassMetadata(Directory::class));
    }

    /**
     * @param Directory $directory
     * @return string
     */
    public function getNamePath(Directory $directory): string
    {
        $path = '';

        /** @var Directory[] $pathElements */
        $pathElements = $this->getPath($directory);
        foreach ($pathElements as $pathElement) {
            $path .= $pathElement->getName() . DIRECTORY_SEPARATOR;
        }

        return $path;
    }

    /**
     * @return Directory
     * @throws EntityNotFoundException
     */
    public function findOneRoot(): Directory
    {
        return $this->findOneById(Directory::ROOT_UUID_STRING);
    }

    /** @noinspection PhpDocMissingThrowsInspection
     * @param string $id
     * @return Directory
     * @throws EntityNotFoundException
     */
    public function findOneById(string $id): Directory
    {
        if(null === ($directory = $this->find($id))) {
            throw new EntityNotFoundException("Could not find directory with id: $id");
        }
        return $directory;
    }

//    /**
//     * @return Directory[] Returns an array of Directory objects
//     */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('d.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Directory
    {
        return $this->createQueryBuilder('d')
            ->andWhere('d.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
