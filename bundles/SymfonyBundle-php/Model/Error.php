<?php
/**
 * Error
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
 * Class representing the Error model.
 *
 * @package Api\Model
 * @author  Swagger Codegen team
 */
class Error 
{
        /**
     * @var string
     * @SerializedName("code")
     * @Assert\NotNull()
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $code;

    /**
     * @var string
     * @SerializedName("message")
     * @Assert\NotNull()
     * @Assert\Type("string")
     * @Type("string")
     */
    protected $message;

    /**
     * Constructor
     * @param mixed[] $data Associated array of property values initializing the model
     */
    public function __construct(array $data = null)
    {
        $this->code = isset($data['code']) ? $data['code'] : null;
        $this->message = isset($data['message']) ? $data['message'] : null;
    }

    /**
     * Gets code.
     *
     * @return string
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Sets code.
     *
     * @param string $code
     *
     * @return $this
     */
    public function setCode(string $code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Gets message.
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Sets message.
     *
     * @param string $message
     *
     * @return $this
     */
    public function setMessage(string $message)
    {
        $this->message = $message;

        return $this;
    }
}


