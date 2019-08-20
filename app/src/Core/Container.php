<?php declare(strict_types=1);

namespace App\Core;

/**
 * Implementation of a simple Dependency injection container
 */
class Container
{
    private $storage = [];
    private $factories;

    public function __construct(array $factories)
    {
        $this->factories = $factories;
    }

    public function make(string $name): object
    {
        if (isset($this->storage[$name])) {
            return $this->storage[$name];
        };

        $service = $this->factories[$name]($this);
        
        return $this->storage[$name] = $service;
    }
}