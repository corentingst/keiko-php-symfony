<?php

namespace App\Controller;

use App\DTO\Tune;
use App\Service\TuneService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class TuneController extends AbstractController
{
    private SerializerInterface $serializer;
    private TuneService $tuneService;


    public function __construct(SerializerInterface $serializer, TuneService $tuneService)
    {
        $this->serializer = $serializer;
        $this->tuneService = $tuneService;
    }

    #[Route('/tune', methods:['GET'])]
    public function getTune(Request $request): Response
    {
        if ($request->query->has("filter")){
            $filter = $request->query->get("filter");
        } else {$filter='';}
//        if (filter is in params ok) else set filter = ''

        $tunesList = $this->tuneService->listTunes($filter);
        return new Response($this->serializer->serialize($tunesList, 'json'));
    }

    #[Route('/tune/{tuneId}', methods:['GET'])]
    public function getTuneID(string $tuneId): Response
    {
        $tune = $this->tuneService->getTune($tuneId);
//
//        $data = [
//            'id' => 1,
//            'title' => 'Tune 1',
//            'author'=>'Artist 1',
//        ];
//
//        $jsonData = $this->serializer->serialize($data, 'json');
//        return new Response($jsonData);#json_encode($jsonData));

        return new Response($this->serializer->serialize($tune, 'json'));
    }

    #[Route('/tune', methods:['POST'])]
    public function postTune(Request $request): Response
    {
//        $tuneToBeCreated = json_decode($request->getContent(), true);
        $tuneToBeCreated = new Tune(1, 'Tune 1', 'Artist 1');
        $tune = $this->tuneService->createTune($tuneToBeCreated);
        return new Response($this->serializer->serialize($tune, 'json'));
    }
    #[Route('/tune/{tuneId}', methods:['DELETE'])]
    public function deleteTuneID(string $tuneId): Response
    {
        $this->tuneService->deleteTune($tuneId);
        return new Response();
    }
}