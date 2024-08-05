<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class MyController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        $luckyURL = $this->generateUrl('number');
        return new Response(
            "<html><body><a href='$luckyURL'> Lucky Number</a></body></html>"
        );
    }

    #[Route('/number', name: 'number')]
    public function number(): Response
    {
        $number = random_int(0, 100);
        $homeURL = $this->generateUrl('home');
        return new Response(
            "<html><body>Lucky number: $number <br> <a href='$homeURL'>HOME</a></body></html>"
        );
    }
}
