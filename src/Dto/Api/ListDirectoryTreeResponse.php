<?php
/**
 * author: abuchatskiy
 */

namespace App\Dto\Api;


use App\Entity\Directory;

class ListDirectoryTreeResponse extends \Api\Model\ListDirectoryTreeResponse
{
    public function __construct(Directory $root)
    {
        parent::__construct();
        $this->root = new DirectoryTreeItem($root);
        $this->root->setName('(root)');
    }

}