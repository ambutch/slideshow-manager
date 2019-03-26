<?php
/**
 * author: abuchatskiy
 */

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class IndexController
 * @package App\Controller
 */
class IndexController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @return Response
     * @throws \LogicException
     */
    public function index(): Response
    {
        return $this->render('index.html.twig');
    }
}