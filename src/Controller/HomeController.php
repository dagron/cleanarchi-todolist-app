<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller
{
    /**
     * @Route("/", name="home")
     */
    public function index()
    {
        $resp = $this->render('home.html.twig');
        $resp->setPublic()
            ->setMaxAge(3600)
            ->setSharedMaxAge(3600);

        return $resp;
    }
}
