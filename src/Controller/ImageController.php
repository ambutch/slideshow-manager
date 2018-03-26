<?php
/**
 * author: abuchatskiy
 */

namespace App\Controller;


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

    /** @noinspection PhpMethodNamingConventionInspection
     * @Route("/image/thumbnail/{id}", name="image_thumbnail")
     * @param string $id
     * @param Request $request
     * @param Glide $glide
     * @param PhotoRepository $photoRepository
     * @return Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \LogicException
     * @throws \InvalidArgumentException
     */
    public function imageThumbnail(string $id, Request $request, Glide $glide, PhotoRepository $photoRepository): Response
    {
        if(null === ($photo = $photoRepository->findOneById(Uuid::fromString($id)))) {
            throw new LogicException("Photo with id: `$id` could not be found");
        }
        $parameters = self::buildImageParameters($request, true);
        return $glide->getImageResponse($photo->getFullPath(), $parameters);
    }

    /** @noinspection PhpMethodNamingConventionInspection
     * @Route("/image/preview/{id}", name="image_preview")
     * @param string $id
     * @param Request $request
     * @param Glide $glide
     * @param PhotoRepository $photoRepository
     * @return Response
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \LogicException
     * @throws \InvalidArgumentException
     */
    public function imagePreview(string $id, Request $request, Glide $glide, PhotoRepository $photoRepository): Response
    {
        if(null === ($photo = $photoRepository->findOneById(Uuid::fromString($id)))) {
            throw new LogicException("Photo with id: `$id` could not be found");
        }
        $parameters = self::buildImageParameters($request, false);
        return $glide->getImageResponse($photo->getFullPath(), $parameters);
    }
}