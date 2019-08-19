<?php

use App\Controller\PetitionsController;
use App\Core\Router;
use App\Core\Container;
use App\Service\ConverterToCsv;
use App\Service\PetitionsApiClient;

$parameters = [
    'routerConfigPath' => __DIR__ . DIRECTORY_SEPARATOR . 'routes.php',
    'templatesPath' => __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . 'templates',
    // Feed url is provided in exercise description
    'feedUrl' => 'https://www.thepetitionsite.com/servlets/petitions/feed.php?type=publisher&feedID=2372',
];

// List of factories intended for generation services instances. It is used by DI Container.
return [

    Router::class => function() use ($parameters) {
        $routerConfig = require_once $parameters['routerConfigPath'];
        return new Router($routerConfig);
    },

    PetitionsController::class => function(Container $container) use ($parameters) {
        $apiClient = $container->make(PetitionsApiClient::class);
        $converter = $container->make(ConverterToCsv::class);
        return new PetitionsController($apiClient, $converter, $parameters['templatesPath']);
    },

    PetitionsApiClient::class => function() use ($parameters) {
        return new PetitionsApiClient($parameters['feedUrl']);
    },

    ConverterToCsv::class => function() {
        return new ConverterToCsv();
    }
];