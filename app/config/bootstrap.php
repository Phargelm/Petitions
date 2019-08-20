<?php declare(strict_types=1);

use App\Core\Container;

spl_autoload_register(function (string $class) {
    
    if (strpos($class, 'App\\') == 0) {
        $class = str_replace('App\\', 'src/', $class);
    }
    
    $class = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    
    require __DIR__ . DIRECTORY_SEPARATOR . '..' . DIRECTORY_SEPARATOR . $class . ".php";
});

$factories = require_once __DIR__ . DIRECTORY_SEPARATOR . 'factories.php';

return new Container($factories);