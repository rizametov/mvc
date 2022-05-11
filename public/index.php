<?php

spl_autoload_register(function ($class) {
    $root = dirname(__DIR__);
    $file = $root . '/' . str_replace('\\', '/', $class) . '.php';
    if (is_readable($file)) {
        require $file;
    }
});

error_reporting(E_ALL);
set_error_handler('Core\Error::errorHandler');
set_exception_handler('Core\Error::exceptionHandler');

$path = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');

$router = new Core\Router();

$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('{controller}/{action}');
$router->add('{controller}/{action}/{\d+}');

// admin section
$router->add('admin/{controller}/{action}', ['namespace' => 'admin']);
$router->add('admin/{controller}/{action}/{\d+}', ['namespace' => 'admin']);

$router->dispatch($path);
