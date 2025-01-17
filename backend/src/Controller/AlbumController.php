<?php

namespace App\Controller;

use App\Components\Albums\TuneAdder;
use App\Components\Albums\AlbumCreator;
use App\Components\Albums\AlbumLister;
use App\Components\Albums\AlbumRetriever;
use App\Components\Albums\TuneRemover;
use App\Components\Tunes\TuneAccessor;
use App\DTO\Album;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\SerializerInterface;

class AlbumController extends AbstractController
{
    public function __construct(
        private SerializerInterface $serializer,
        private AlbumCreator        $albumCreator,
        private AlbumLister         $albumLister,
        private AlbumRetriever      $albumRetriever,
        private TuneAdder           $tuneAdder,
        private TuneAccessor        $tuneAccessor,
        private TuneRemover         $tuneRemover,
    ){}
    #[Route('/album', methods: ['POST'])]
    public function postAlbum(Request $request): Response {
        $requestContent = json_decode($request->getContent(), true);
        if (isset($requestContent['title']) and isset($requestContent['issueDate']))
        {
            $albumToCreate = new Album();
            $albumToCreate->setTitle($requestContent["title"]);
            $albumToCreate->setIssueDate($requestContent["issueDate"]);
            $album = $this->albumCreator->createAlbum($albumToCreate);
            return new Response($this->serializer->serialize($album, 'json'));
        }
        return new Response("Le format de la requête n'est pas respecté");
    }
    #[Route('/album', methods: ['GET'])]
    public function getAlbumList(Request $request): Response
    {
        if ($request->query->has("filter")){
            $filterValue = $request->query->get("filter");
        } else {$filterValue='';}

        $albumList = $this->albumLister->listAlbums($filterValue);
        return new Response($this->serializer->serialize($albumList, 'json'));
    }

    #[Route('/album/{albumId}', methods: ['GET'])]
    public function getAlbumInfo(Request $request, string $albumId): Response
    {
        $albumEntity = $this->albumRetriever->getAlbumEntity($albumId);
        $tuneCollection = $albumEntity->getTunes();
        $albumJSON = $this->serializer->serialize($albumEntity, 'json');
        $collectionJSON = $this->serializer->serialize($tuneCollection, 'json');
        return new Response($albumJSON);
    }

    #[Route('/album/{albumId}/tune/{tuneId}', methods: ['POST'])]
    public function addTuneToAlbum(string $albumId, string $tuneId): Response
    {
        // rajouter conditions pour avoir des requetes qui fonctionnent dans tous les cas
//        $album = $this->albumRetriever->getAlbum($albumId);
//        $tune = $this->tuneAccessor->getTune($tuneId);
//        $this->tuneAdder->addTuneToAlbum($tune, $album);
        $this->tuneAdder->addTuneToAlbum($tuneId, $albumId);
        return new Response("Le titre {$tuneId} a bien été ajouté à l'album {$albumId}");
    }
    #[Route('/album/{albumId}/tune/{tuneId}', methods: ['DELETE'])]
    public function deleteTuneFromAlbum(string $albumId, string $tuneId): Response
    {
        // rajouter conditions pour avoir des requetes qui fonctionnent dans tous les cas
        $this->tuneRemover->removeTuneFromAlbum($tuneId, $albumId);
        return new Response("Le titre {$tuneId} a bien été retiré à l'album {$albumId}");
    }

}