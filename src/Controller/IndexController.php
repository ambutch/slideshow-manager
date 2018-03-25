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

class IndexController extends Controller
{
    /**
     * @Route("/", name="index")
     * @return Response
     * @throws \InvalidArgumentException
     */
    public function index(): Response
    {
        return new Response();
    }

    /** @noinspection PhpMethodNamingConventionInspection
     * @Route("/img_thumbnail/{path}", name="img_thumbnail")
     * @param $path
     * @param Request $request
     * @param Glide $glide
     * @return Response
     * @throws \InvalidArgumentException
     */
    public function imageThumbnail($path, Request $request, Glide $glide): Response
    {
        $parameters = $this->buildImageParameters($request, true);
        return $glide->getImageResponse($path, $parameters);
    }

    /** @noinspection PhpMethodNamingConventionInspection
     * @Route("/img_preview/{path}", name="img_preview")
     * @param $path
     * @param Request $request
     * @param Glide $glide
     * @return Response
     * @throws \InvalidArgumentException
     */
    public function imagePreview($path, Request $request, Glide $glide): Response
    {
        $parameters = $this->buildImageParameters($request, false);
        return $glide->getImageResponse($path, $parameters);
    }

    /**
     * @param Request $request
     * @param bool|null $crop
     * @return array
     */
    public function buildImageParameters(Request $request, bool $crop = null): array
    {
        $parameters = [];
        $width = $request->get('w');
        $height = $request->get('h');
        if (null !== $width && null !== $height) {
            $crop ?: false;
            $parameters['w'] = (int)$width;
            $parameters['h'] = (int)$height;
            $parameters['fit'] = $crop ? 'crop' : 'fill';
        }
        return $parameters;
    }
}