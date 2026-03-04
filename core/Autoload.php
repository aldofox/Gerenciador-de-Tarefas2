<?php
spl_autoload_register(function ($class) {
    $paths = [
        '../controllers/',
        '../models/',
        '../core/',
        '../config'
    ];

    foreach ($paths as $path){
        if (file_exists($path .$class . '.php')) {
            require_once $path .$class . '.php';
            return;
        }
    }
});