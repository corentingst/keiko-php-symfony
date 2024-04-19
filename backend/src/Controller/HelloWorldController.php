<?php

//declare(strict_types=1);

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HelloWorldController extends AbstractController {
    #[Route('/hello', methods: ['GET'])]
    public function hello(): Response
    {
        return new Response('Hello World!');
    }
    #[Route('/hello/{personsNumber}', methods: ['GET'], requirements: ['personsNumber' => '\d+'])]
    public function helloMultiplePeople(int $personsNumber): Response
    {
        return new Response("Hello {$personsNumber} people!");
    }

    #[Route("/hello/{name}", methods: ['GET'])]
    public function helloYou(Request $request, string $name): Response
    {
        $page = $request->query->get("page");
        $size = $request->query->get("size");

        $data = json_decode($request->getContent(), true);
        $dataString = json_encode($data);

        return new Response("Hello {$name}! You requested page: {$page} of size: {$size}!. Data: {$dataString}");
    }
    #[Route("/hello/param", methods: ['GET'])]
    public function list(Request $request): Response
    {
        $routeName = $request->attributes->get('_route');

        if ($request->query->has("page")) {
            $page = $request->query->get("page");

            return new Response("Page: {$page}");
        }

        $routeParameters = $request->attributes->get('_route_params');

        // use this to get all the available attributes (not only routing ones):
        $allAttributes = $request->attributes->all();
        $routeParams_string = json_encode($routeParameters);
        $allParams_string = json_encode($allAttributes);
        return new Response("Route name: {$routeName}, route parameters: {$routeParams_string}, all params: {$allParams_string}");
    }


}