<?php
/**
 * author: abuchatskiy
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class IndexController
 * @package App\Controller
 */
class IndexController extends Controller
{
    /**
     * @Route("/", name="index")
     * @return Response
     * @throws \InvalidArgumentException
     */
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }
}