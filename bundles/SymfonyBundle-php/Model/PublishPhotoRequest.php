<?php
/**
 * PublishPhotoRequest
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
 * Class representing the PublishPhotoRequest model.
 *
 * @package Api\Model
 * @author  Swagger Codegen team
 */
class PublishPhotoRequest 
{
        /**
     * @var string
     * @SerializedName("photoId")
     * @Assert\NotNull()
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $photoId;

    /**
     * @var bool
     * @SerializedName("published")
     * @Assert\NotNull()
     * @Assert\Type("bool")
     * @Type("bool")
     */
    protected $published;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property values initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->photoId = isset($data['photoId']) ? $data['photoId'] : null;
        $this->published = isset($data['published']) ? $data['published'] : null;
    }

    /**
     * Gets photoId.
     *
     * @return string
     */
    public function getPhotoId()
    {
        return $this->photoId;
    }

    /**
     * Sets photoId.
     *
     * @param string $photoId
     *
     * @return $this
     */
    public function setPhotoId(string $photoId)
    {
        $this->photoId = $photoId;

        return $this;
    }

    /**
     * Gets published.
     *
     * @return bool
     */
    public function isPublished()
    {
        return $this->published;
    }

    /**
     * Sets published.
     *
     * @param bool $published
     *
     * @return $this
     */
    public function setPublished(bool $published)
    {
        $this->published = $published;

        return $this;
    }
}

