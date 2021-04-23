<?php

namespace App\MessageHandler;

use App\Message\SetCoord;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class SetCoordHandler
{

    //constructeur
    public $client;

    public function __construct(HttpClientInterface $client)
    {

        $this->client = $client;

    }

    public function __invoke(SetCoord $coord)
    {

        //$coord contient lat et lng
        $lat = $coord->getLat();
        $lng = $coord->getLng();

        //donc le handler traite ici la requête
        $response = $this->client->request('POST', 'http://localhost:3000', ['body' => ['lat' => $lat, 'lng' => $lng]]);

        dump($response->getContent());

        return $response->getContent();

    }

}
