<?php declare(strict_types=1);

namespace App\Core;

class Router
{
    private $config;

    public function __construct(array $config)
    {
        $this->config = $config;
    }

    /**
     * Implementation of simple matching logic by full comparison using requested path and HTTP method
     */
    public function getAction(string $path, string $method): ?array
    {
        $matchedPath = $this->config[$path] ?? null;

        if (!$matchedPath) {
            return null;
        }

        return $matchedPath[$method] ?? null;
    }
}