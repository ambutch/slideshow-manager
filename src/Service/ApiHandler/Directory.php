<?php /** @noinspection ReturnTypeCanBeDeclaredInspection */
/** @noinspection PhpOptionalBeforeRequiredParametersInspection */

/**
 * author: abuchatskiy
 */

namespace App\Service\ApiHandler;


use Api\DirectoryApiInterface;
use App\Service\ApiManager\Directory as DirectoryManager;

/**
 * Class Directory
 * @package App\Service\ApiHandler
 */
class Directory implements DirectoryApiInterface
{
    /**
     * @var DirectoryManager
     */
    protected $manager;

    /**
     * Directory constructor.
     * @param DirectoryManager $manager
     */
    public function __construct(DirectoryManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Operation listDirectoryTree
     *
     * Directory tree
     *
     * @param  integer $responseCode The HTTP response code to return
     * @param  array $responseHeaders Additional HTTP headers to return with the response ()
     *
     * @return \Api\Model\ListDirectoryTreeResponse
     *
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function listDirectoryTree(&$responseCode, array &$responseHeaders)
    {
        return $this->manager->buildDirectoryTree();
    }

    /**
     * Operation listDirectory
     *
     * Directory contents
     *
     * @param  string $id (required)
     * @param  int $page (optional)
     * @param  int $limit (optional)
     * @param  string $sort (optional)
     * @param  string $dir (optional)
     * @param  integer $responseCode The HTTP response code to return
     * @param  array $responseHeaders Additional HTTP headers to return with the response ()
     *
     * @return \Api\Model\ListDirectoryInfoResponse
     *
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function listDirectory(string $id, int $page = null, int $limit = null, string $sort = null, string $dir = null, &$responseCode, array &$responseHeaders)
    {
        return $this->manager->listDirectory($id);
    }
}