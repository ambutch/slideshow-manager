<?php
/**
 * author: abuchatskiy
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class ListingController
 * @package App\Controller
 */
class ListingController extends Controller
{

    public function buildTree(string $path): Response
    {
        return new JsonResponse();
    }

    public function listDirectory(string $path): Response
    {
        return new JsonResponse();
    }
}