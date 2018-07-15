<?php
/**
 * PhotoApiInterface
 * PHP version 5
 *
 * @category Class
 * @package  Api
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

namespace Api;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Api\Model\Error;
use Api\Model\PublishPhotoRequest;

/**
 * PhotoApiInterface Interface Doc Comment
 *
 * @category Interface
 * @package  Api
 * @author   Swagger Codegen team
 * @link     https://github.com/swagger-api/swagger-codegen
 */
interface PhotoApiInterface
{

    /**
     * Operation publishPhoto
     *
     * Publish photo to slideshow directory
     *
     * @param  \Api\Model\PublishPhotoRequest $body   (required)
     * @param  integer $responseCode     The HTTP response code to return
     * @param  array   $responseHeaders  Additional HTTP headers to return with the response ()
     *
     * @return void
     *
     */
    public function publishPhoto(PublishPhotoRequest $body, &$responseCode, array &$responseHeaders);
}