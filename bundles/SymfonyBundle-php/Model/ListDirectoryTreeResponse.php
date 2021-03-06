<?php
/**
 * ListDirectoryTreeResponse
 *
 * PHP version 5
 *
 * @category Class
 * @package  Api\Model
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */

/**
 * Slideshow manager
 *
 * API for Slideshow manager SPA
 *
 * OpenAPI spec version: 1.0.0
 * 
 * Generated by: https://github.com/swagger-api/swagger-codegen.git
 *
 */

/**
 * NOTE: This class is auto generated by the swagger code generator program.
 * https://github.com/swagger-api/swagger-codegen
 * Do not edit the class manually.
 */

namespace Api\Model;

use Symfony\Component\Validator\Constraints as Assert;
use JMS\Serializer\Annotation\Type;
use JMS\Serializer\Annotation\SerializedName;

/**
 * Class representing the ListDirectoryTreeResponse model.
 *
 * @package Api\Model
 * @author  Swagger Codegen team
 */
class ListDirectoryTreeResponse 
{
        /**
     * @var \Api\Model\DirectoryTreeItem|null
     * @SerializedName("root")
     * @Assert\Type("Api\Model\DirectoryTreeItem")
     * @Type("Api\Model\DirectoryTreeItem")
     */
    protected $root;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property values initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->root = isset($data['root']) ? $data['root'] : null;
    }

    /**
     * Gets root.
     *
     * @return \Api\Model\DirectoryTreeItem|null
     */
    public function getRoot()
    {
        return $this->root;
    }

    /**
     * Sets root.
     *
     * @param \Api\Model\DirectoryTreeItem|null $root
     *
     * @return $this
     */
    public function setRoot(DirectoryTreeItem $root = null)
    {
        $this->root = $root;

        return $this;
    }
}


