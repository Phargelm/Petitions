<?php declare(strict_types=1);

namespace App\Service\Petitions;

use App\Service\Utils\PetitionsApiClient\PetitionsApiClient;
use App\Service\Utils\PetitionsApiClient\PetitionsApiClientException;

class PetitionsService
{
    private $apiClient;
    
    public function __construct(PetitionsApiClient $apiClient)
    {
        $this->apiClient = $apiClient;
    }

    public function getPetitions(): array
    {
        try {
            $petitions = $this->apiClient->getPetitions();
        } catch (PetitionsApiClientException $exception) {
            throw new PetitionsException('Unable to get petitions list.', 0, $exception);
        }
        
        // sorting petitions by stopdate in descending order
        usort($petitions, function(array $petition1, array $petition2) {

            if (empty($petition1['stopdate']) || empty($petition2['stopdate'])) {
                throw new PetitionsException('Petition stop date is not found.');
            }

            $petitionStopDate1 = strtotime($petition1['stopdate']);
            $petitionStopDate2 = strtotime($petition2['stopdate']);

            if ($petitionStopDate1 === false || $petitionStopDate2 === false) {
                throw new PetitionsException('Petition stop date format is invalid.');
            }

            return -($petitionStopDate1 <=> $petitionStopDate2);
        });
        
        return $petitions;
    }
}