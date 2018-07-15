<?php
/**
 * ListDirectoryInfoResponse
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
 * Class representing the ListDirectoryInfoResponse model.
 *
 * @package Api\Model
 * @author  Swagger Codegen team
 */
class ListDirectoryInfoResponse 
{
        /**
     * @var string
     * @SerializedName("path")
     * @Assert\NotNull()
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $path;

    /**
     * @var \Api\Model\PhotoInfo[]
     * @SerializedName("photos")
     * @Assert\NotNull()
     * @Assert\All({
     *   @Assert\Type("Api\Model\PhotoInfo")
     * })
     * @Type("array<Api\Model\PhotoInfo>")
     */
    protected $photos;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property values initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->path = isset($data['path']) ? $data['path'] : null;
        $this->photos = isset($data['photos']) ? $data['photos'] : null;
    }

    /**
     * Gets path.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Sets path.
     *
     * @param string $path
     *
     * @return $this
     */
    public function setPath(string $path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Gets photos.
     *
     * @return \Api\Model\PhotoInfo[]
     */
    public function getPhotos()
    {
        return $this->photos;
    }

    /**
     * Sets photos.
     *
     * @param \Api\Model\PhotoInfo[] $photos
     *
     * @return $this
     */
    public function setPhotos(PhotoInfo $photos)
    {
        $this->photos = $photos;

        return $this;
    }
}

