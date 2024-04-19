<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class TuneController extends AbstractController
{
    private SerializerInterface $serializer;

    public function __construct(SerializerInterface $serializer)
    {
        $this->serializer = $serializer;
    }

    #[Route('/tune', methods:['GET'])]
    public function tune(): Response
    {
        return new Response();
    }

    #[Route('/tune/{id}', methods:['GET'])]
    public function tuneID(): Response
    {
        $data = [
            'id' => 1,
            'title' => 'Tune 1',
            'author'=>'Artist 1',
        ];

        $jsonData = $this->serializer->serialize($data, 'json');
        return new Response($jsonData);#json_encode($jsonData));
    }

    #[Route('/tune', methods:['POST'])]
    public function postTune(): Response
    {
        return new Response();
    }
    #[Route('/tune/{id}', methods:['DELETE'])]
    public function deleteTuneID(): Response
    {
        return new Response();
    }
}