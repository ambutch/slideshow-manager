<?php
/**
 * author: abuchatskiy
 */

namespace App\Controller;


use League\Glide\Server as Glide;
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
    public static function buildImageParameters(Request $request, bool $crop = null): array
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
     * @Route("/image/thumbnail/{path}", name="image_thumbnail")
     * @param string $path
     * @param Request $request
     * @param Glide $glide
     * @return Response
     * @throws \InvalidArgumentException
     */
    public function imageThumbnail(string $path, Request $request, Glide $glide): Response
    {
        $parameters = self::buildImageParameters($request, true);
        return $glide->getImageResponse($path, $parameters);
    }

    /** @noinspection PhpMethodNamingConventionInspection
     * @Route("/image/preview/{path}", name="image_preview")
     * @param string $path
     * @param Request $request
     * @param Glide $glide
     * @return Response
     * @throws \InvalidArgumentException
     */
    public function imagePreview(string $path, Request $request, Glide $glide): Response
    {
        $parameters = self::buildImageParameters($request, false);
        return $glide->getImageResponse($path, $parameters);
    }
}