<?php
/**
 * author: abuchatskiy
 */

namespace App\Dto\Api;


use App\Entity\Directory;

class ListDirectoryInfoResponse extends \Api\Model\ListDirectoryInfoResponse
{
    public function __construct(Directory $directory)
    {
        parent::__construct();
        $this->path = $directory->getName();
        $this->photos = [];
        foreach ($directory->getPhotos() as $photo) {
            $this->photos[] = new PhotoInfo($photo);
        }
    }

}