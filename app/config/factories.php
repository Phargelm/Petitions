<?php declare(strict_types=1);

use App\Controller\PetitionsController;
use App\Core\Router;
use App\Core\Container;
use App\Service\Petitions\PetitionsService;
use App\Service\Utils\ConverterToCsv;
use App\Service\Utils\PetitionsApiClient\PetitionsApiClient;

$parameters = require_once __DIR__ . DIRECTORY_SEPARATOR .  'parameters.php';

// List of factories intended for generation services instances. It is used by DI Container.
return [

    Router::class => function() use ($parameters) {
        $routerConfig = require_once $parameters['routerConfigPath'];
        return new Router($routerConfig);
    },

    PetitionsController::class => function(Container $container) use ($parameters) {
        $petitionsService = $container->make(PetitionsService::class);
        $converter = $container->make(ConverterToCsv::class);
        
        return new PetitionsController($converter, $petitionsService, $parameters['templatesPath'],
            $parameters['csvFilename']);
    },

    PetitionsService::class => function (Container $container) {
        $apiClient = $container->make(PetitionsApiClient::class);
        return new PetitionsService($apiClient);
    },

    PetitionsApiClient::class => function() use ($parameters) {
        return new PetitionsApiClient($parameters['feedUrl']);
    },

    ConverterToCsv::class => function() {
        return new ConverterToCsv();
    },
];