<?php

namespace App\Controller;

use App\Service\ConverterToCsv;
use App\Service\PetitionsApiClient;

class PetitionsController
{
    private $converter;
    private $apiClient;
    private $templatesPath;

    public function __construct(PetitionsApiClient $apiClient, ConverterToCsv $converter, string $templatesPath)
    {
        $this->templatesPath = $templatesPath;
        $this->apiClient = $apiClient;
        $this->converter = $converter;
    }

    public function index(): void
    {
        require $this->templatesPath . DIRECTORY_SEPARATOR . 'index.html';
    }

    public function getPetitions(array $requestParams)
    {
        $petitions = $this->apiClient->getPetitions();

        // sorting petitions by stopdate in descending order
        usort($petitions, function(array $petition1, array $petition2) {
            return -(strtotime($petition1['stopdate']) <=> strtotime($petition2['stopdate']));
        });
        
        $resource = $this->converter->convert($petitions, $requestParams, array_keys($requestParams));

        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename=petitions.csv;"');

        fpassthru($resource);
    }
}