<?php

namespace App\Service;

use App\DTO\Tune;

class TuneService
{
    public function  getTune(String $tuneId): Tune {
//        // Instancier un nouvel objet Tune
//        $tune = new Tune();
//
//        // Utiliser des méthodes de l'objet Tune
//        $tune->setId('OI');
//        $tune->setTitle('My Tune');
//        $tune->setAuthor('John Doe');
//
//        return new Response($tune);
        return new Tune(1, 'Tune 1', 'Artist 1');
    }
    public function  createTune(Tune $tuneToBeCreated): Tune {
        return $tuneToBeCreated;
    }
    public function  deleteTune(String $tuneId): void{

    }
    public function  listTunes(): array {
        return([]);
    }
}