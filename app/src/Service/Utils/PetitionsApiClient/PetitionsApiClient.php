<?php declare(strict_types=1);

namespace App\Service\Utils\PetitionsApiClient;

class PetitionsApiClient
{
    private $curl;
    
    public function __construct(string $feedUrl)
    {
        // I will use the curl in order to fetch data, it is faster than file_get_contents()
        $this->curl = curl_init();
        curl_setopt_array($this->curl, [
            CURLOPT_URL => $feedUrl,
            CURLOPT_RETURNTRANSFER => true,
        ]);
    }

    public function getPetitions(): array
    {        
        $rawData = curl_exec($this->curl);

        if ($rawData === false) {
            $errorMessage = 'Error is occured during request: ' . curl_error($this->curl);
            throw new PetitionsApiClientException($errorMessage);
        }

        $parsedPetitions = json_decode($rawData, true);

        if ($parsedPetitions === null) {
            throw new PetitionsApiClientException('JSON cannot be decoded.');
        }

        if (empty($parsedPetitions['petitions'] || !is_array($parsedPetitions['petitions']))) {
            throw new PetitionsApiClientException('No petitions found in response.');
        }

        return $parsedPetitions['petitions'];
    }
}