<?php
/**
 * author: abuchatskiy
 */

namespace App\Service\ApiManager;


use Api\Model\PublishPhotoRequest;
use App\Repository\PhotoRepository;
use App\Service\PublishManager;

/**
 * Class Photo
 * @package App\Service\ApiManager
 */
class Photo
{
    /**
     * @var PhotoRepository
     */
    protected $photoRepo;

    /**
     * @var PublishManager
     */
    protected $publishManager;

    /**
     * Photo constructor.
     * @param PhotoRepository $photoRepo
     * @param PublishManager $publishManager
     */
    public function __construct(PhotoRepository $photoRepo, PublishManager $publishManager)
    {
        $this->photoRepo = $photoRepo;
        $this->publishManager = $publishManager;
    }

    /**
     * @param PublishPhotoRequest $request
     * @throws \Doctrine\ORM\EntityNotFoundException
     * @throws \Doctrine\ORM\ORMException
     * @throws \League\Flysystem\FileExistsException
     * @throws \League\Flysystem\FileNotFoundException
     * @throws \League\Glide\Filesystem\FileNotFoundException
     * @throws \League\Glide\Filesystem\FilesystemException
     */
    public function changePhotoState(PublishPhotoRequest $request): void
    {
        $photo = $this->photoRepo->findOneById($request->getPhotoId());
        $this->publishManager->changeState($photo, $request->isPublished());
    }
}