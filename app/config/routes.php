<?php

return [
    
    '/' => [
        'GET' => [
            'action' => 'index',
            'controller' => 'App\Controller\PetitionsController',
        ],
    ],

    '/petitions' => [
        'GET' => [
            'action' => 'getPetitions',
            'controller' => 'App\Controller\PetitionsController'
        ]
    ]

    // another routes can be defined here...
];