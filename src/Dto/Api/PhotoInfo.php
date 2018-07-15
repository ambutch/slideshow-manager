<?php
/**
 * author: abuchatskiy
 */

namespace App\Dto\Api;


use App\Entity\Photo;

class PhotoInfo extends \Api\Model\PhotoInfo
{
    public function __construct(Photo $photo)
    {
        parent::__construct();
        $this->id = $photo->getId()->toString();
        $this->name = $photo->getBaseName();
        $this->published = $photo->isPublished();
    }

}