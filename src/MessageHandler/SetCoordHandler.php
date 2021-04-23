<?php

namespace App\MessageHandler;

use App\Message\SetCoord;

class SetCoorHandler
{

    //constructeur

    // method __invoke
    //contient toute la logic du traitement du message reçu

    //arg === sera la class qui représente le message à traiter
    public function __invoke(SetCoord $coord)
    {

        //$coord contient lat et lng
        $lat = $coord->getLat();
        $lng = $coord->getLng();

        //donc le handler traite ici la requête


        

    }

}
