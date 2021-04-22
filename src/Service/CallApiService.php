<?php

namespace App\Service;

class CallApiService
{


    private $prop;

    private $urlAvgTemp = 'http://localhost:3000/meteo/average/temperature';
    private $urlMostHotDays = 'http://localhost:3000/meteo/mosthotdays';
    private $urlAvgUvi = 'http://localhost:3000/meteo/average/uvi';
    private $urlRainfallDay = 'http://localhost:3000/meteo/highest/rainfallday';
    private $url = 'http://localhost:3000';


    public function getRootUrl()
    {
        return $this->url;
    }

    public function getUrlAvgTemp(): string
    {
        return $this->urlAvgTemp;
    }

    public function getUrlMostHotDays(): string
    {
        return $this->urlMostHotDays;
    }

    public function getUrlAvgUvi(): string
    {
        return $this->urlAvgUvi;
    }

    public function getUrlRainfallDay(): string
    {
        return $this->urlRainfallDay;
    }

    // public function wichRoute($client, $found)
    // {

    //     $response = $client->request(
    //         'POST',
    //         self::getRootUrl(),
    //         ["body" => ["lat" => $found->getLat(), "lng" => $found->getLng()]]

    //     );

    //     return $response;
    // }

}
