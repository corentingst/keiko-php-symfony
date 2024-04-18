<?php

//declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HelloWorldController extends AbstractController {
    #[Route('/hello', methods: ['GET'])]
    public function hello(): Response
{
    return new Response('Hello World2!');
}
}