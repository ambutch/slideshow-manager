<?php
/**
 * author: abuchatskiy
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PublishController
 * @package App\Controller
 */
class PublishController extends Controller
{
    /** @noinspection PhpMethodNamingConventionInspection
     * @Route("/publish/{path}/{state}", name="img_publish")
     * @param string $path
     * @param bool $state
     * @param Request $request
     * @return Response
     * @throws \InvalidArgumentException
     */
    public function changePublishState(string $path, bool $state, Request $request): Response
    {
        //TODO implement
        return new Response();
    }
}