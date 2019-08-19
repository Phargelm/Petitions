<?php

namespace App\Service;

class PetitionsApiClient
{
    private $curl;

    public function __construct(string $feedUrl)
    {
        // I will use the curl in order to fetch data, it is faster than file_get_contents()
        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($this->curl, CURLOPT_URL, $feedUrl);
    }

    public function getPetitions(): array
    {        
        $rawData = curl_exec($this->curl);

        if ($rawData === false) {
            throw new \Exception(curl_error($this->curl));
        }

        $parsedPetitions = json_decode($rawData, true);

        if ($parsedPetitions === null) {
            throw new \Exception('JSON cannot be decoded');
        }

        return $parsedPetitions['petitions'];
    }
}