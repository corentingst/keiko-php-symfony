<?php

namespace App\Controller;

use App\Components\Tunes\TuneAccessor;
use App\Components\Tunes\TuneCreator;
use App\Components\Tunes\TuneDeleter;
use App\Components\Tunes\TuneLister;
use App\DTO\Tune;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;

class TuneController extends AbstractController
{
    public function __construct(
        public SerializerInterface $serializer,
        public TuneAccessor $tuneAccessor,
        public TuneCreator $tuneCreator,
        public TuneDeleter $tuneDeleter,
        public TuneLister $tuneLister
    ){}

    #[Route('/tune', methods:['GET'])]
    public function getTune(Request $request): Response
    {
        if ($request->query->has("filter")){
            $filter = $request->query->get("filter");
        } else {$filter='';}

        $tunesList = $this->tuneLister->listTunes($filter);
        return new Response($this->serializer->serialize($tunesList, 'json'));
    }

    #[Route('/tune/{tuneId}', methods:['GET'])]
    public function getTuneID(string $tuneId): Response
    {
        $tune = $this->tuneAccessor->getTune($tuneId);
        return new Response($this->serializer->serialize($tune, 'json'));
    }

    #[Route('/tune', methods:['POST'])]
    public function postTune(Request $request): Response
    {
        $requestContent = json_decode($request->getContent(), true);
        if (isset($requestContent['title']) and isset($requestContent['author']))
        {
            $tuneToBeCreated = new Tune();
            $tuneToBeCreated->setTitle($requestContent["title"]);
            $tuneToBeCreated->setAuthor($requestContent["author"]);
            $tune = $this->tuneCreator->createTune($tuneToBeCreated);
            return new Response($this->serializer->serialize($tune, 'json'));
        }
        return new Response("Le format de la requête n'est pas respecté");
    }

    #[Route('/tune/{tuneId}', methods:['DELETE'])]
    public function deleteTuneID(string $tuneId): Response
    {
        $this->tuneDeleter->deleteTune($tuneId);
        return new Response();
    }
}