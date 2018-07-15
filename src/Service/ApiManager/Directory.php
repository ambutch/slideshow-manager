<?php
/**
 * author: abuchatskiy
 */

namespace App\Service\ApiManager;


use App\Dto\Api\ListDirectoryInfoResponse;
use App\Dto\Api\ListDirectoryTreeResponse;
use App\Repository\DirectoryRepository;

/**
 * Class Directory
 * @package App\Service\ApiManager
 */
class Directory
{
    /**
     * @var DirectoryRepository
     */
    protected $repo;

    /**
     * Directory constructor.
     * @param DirectoryRepository $repo
     */
    public function __construct(DirectoryRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * @return ListDirectoryTreeResponse
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function buildDirectoryTree(): ListDirectoryTreeResponse
    {
        return new ListDirectoryTreeResponse($this->repo->findOneRoot());
    }

    /**
     * @param string $directoryId
     * @param int|null $page
     * @param int|null $limit
     * @param null|string $sort
     * @param null|string $dir
     * @return ListDirectoryInfoResponse
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function listDirectory(
        string $directoryId,
        ?int $page = null,
        ?int $limit = null,
        ?string $sort = null,
        ?string $dir = null
    ): ListDirectoryInfoResponse
    {
        return new ListDirectoryInfoResponse($this->repo->findOneById($directoryId));
    }
}