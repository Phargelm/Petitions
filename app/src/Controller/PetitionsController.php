<?php declare(strict_types=1);

namespace App\Controller;

use App\Service\Utils\ConverterToCsv;
use App\Service\Petitions\PetitionsService;

class PetitionsController
{
    private $converter;
    private $petitionsService;
    private $templatesPath;
    private $csvFilename;

    public function __construct(
        ConverterToCsv $converter,
        PetitionsService $petitionsService,
        string $templatesPath,
        string $csvFilename)
    {
        $this->templatesPath = $templatesPath;
        $this->petitionsService = $petitionsService;
        $this->converter = $converter;
        $this->csvFilename = $csvFilename;
    }

    public function index(): void
    {
        require $this->templatesPath . DIRECTORY_SEPARATOR . 'index.html';
    }

    public function getPetitions(array $requestParams): void
    {
        // if an exception will be thrown let it bubble up to the app exception handler
        $petitions = $this->petitionsService->getPetitions();
        
        // converting petitions to csv format
        $resource = $this->converter->convert($petitions, $requestParams, array_keys($requestParams));

        header('Content-Type: application/csv');
        header('Content-Disposition: attachment; filename='. $this->csvFilename . ';"');

        fpassthru($resource);
    }
}