<?php /** @noinspection BadExceptionsProcessingInspection */

/**
 * author: abuchatskiy
 */

namespace App\Service\ApiHandler;


use Api\Model\PublishPhotoRequest;
use Api\PhotoApiInterface;
use App\Service\ApiManager\Photo as PhotoManager;
use Doctrine\ORM\EntityNotFoundException;

class Photo implements PhotoApiInterface
{

    /**
     * @var PhotoManager
     */
    protected $manager;

    /**
     * Photo constructor.
     * @param PhotoManager $manager
     */
    public function __construct(PhotoManager $manager)
    {
        $this->manager = $manager;
    }

    /**
     * Operation publishPhoto
     *
     * Publish photo to slideshow directory
     *
     * @param  \Api\Model\PublishPhotoRequest $body (required)
     * @param  integer $responseCode The HTTP response code to return
     * @param  array $responseHeaders Additional HTTP headers to return with the response ()
     *
     * @return void
     *
     */
    public function publishPhoto(PublishPhotoRequest $body, &$responseCode, array &$responseHeaders)
    {
        try {
            $this->manager->changePhotoState($body);
        } catch (EntityNotFoundException $e) {
            $responseCode = 404;
        } catch (\Exception $e) {
            $responseCode = 400;
        }
    }
}