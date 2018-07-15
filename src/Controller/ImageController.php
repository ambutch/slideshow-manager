<?php
/**
 * author: abuchatskiy
 */

namespace App\Controller;


use App\Entity\Photo;
use App\Repository\PhotoRepository;
use League\Glide\Server as Glide;
use LogicException;
use Ramsey\Uuid\Uuid;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ImageController
 * @package App\Controller
 */
class ImageController extends Controller
{

    /**
     * @var Glide
     */
    protected $glide;

    /**
     * @var PhotoRepository
     */
    protected $photoRepository;

    /**
     * ImageController constructor.
     * @param Glide $glide
     * @param PhotoRepository $photoRepository
     */
    public function __construct(Glide $glide, PhotoRepository $photoRepository)
    {
        $this->glide = $glide;
        $this->photoRepository = $photoRepository;
    }

    /**
     * @param Request $request
     * @param bool|null $crop
     * @return array
     */
    protected static function buildImageParameters(Request $request, bool $crop = null): array
    {
        $parameters = [];
        $width = $request->get('w');
        $height = $request->get('h');
        if (null !== $width && null !== $height) {
            $parameters['w'] = (int)$width;
            $parameters['h'] = (int)$height;
            /** @noinspection NestedTernaryOperatorInspection */
            $parameters['fit'] = ($crop ?: false) ? 'crop' : 'fill';
        }
        return $parameters;
    }

    /**
     * @param Photo $photo
     * @param array $parameters
     * @return Response
     * @throws \InvalidArgumentException
     */
    protected function generateImageResponse(Photo $photo, array $parameters): Response
    {
        return $this->glide->getImageResponse($photo->getFullPath(), $parameters);
    }

    /** @noinspection PhpMethodNamingConventionInspection
     * @param string $id
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function imageThumbnail(string $id, Request $request): Response
    {
        $photo = $this->photoRepository->findOneById($id);
        $parameters = self::buildImageParameters($request, true);
        return $this->generateImageResponse($photo, $parameters);
    }

    /** @noinspection PhpMethodNamingConventionInspection
     * @param string $id
     * @param Request $request
     * @return Response
     * @throws \Doctrine\ORM\EntityNotFoundException
     */
    public function imagePreview(string $id, Request $request): Response
    {
        $photo = $this->photoRepository->findOneById($id);
        $parameters = self::buildImageParameters($request, false);
        return $this->generateImageResponse($photo, $parameters);
    }
}