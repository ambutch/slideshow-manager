<?php
/**
 * author: abuchatskiy
 */

namespace App\Dto\Api;


use App\Entity\Directory;

class DirectoryTreeItem extends \Api\Model\DirectoryTreeItem
{
    public function __construct(Directory $directory)
    {
        parent::__construct();

        $this->id = $directory->getId()->toString();
        $this->name = $directory->getName();
        $this->children = [];
        foreach ($directory->getChildDirectories() as $childDirectory) {
            $this->children[] = new DirectoryTreeItem($childDirectory);
        }
    }

}