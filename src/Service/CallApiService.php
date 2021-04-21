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

    public function getUrlAvgTemp(string $urlAvgTemp): string
    {
        return $this->urlAvgTemp = $urlAvgTemp;
    }

    public function getUrlMostHotDays(string $urlMostHotDays): string
    {
        return $this->urlMostHotDays = $urlMostHotDays;
    }

    public function getUrlAvgUvi(string $urlAvgUvi): string
    {
        return $this->urlAvgUvi = $urlAvgUvi;
    }

    public function getUrlRainfallDay(string $urlRainfallDay): string
    {
        return $this->urlRainfallDay = $urlRainfallDay;
    }

}
