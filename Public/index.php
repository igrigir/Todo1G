<?php
// Public/index.php

// 1) Prikaz grešaka (dev only)
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

// 2) (NE) koristi Composer autoload ako nemaš vendor/
// require __DIR__ . '/../vendor/autoload.php';

// 3) Jednostavan autoloader (radi i na PHP 7.x)
spl_autoload_register(function ($class) {
    $prefix = 'App\\';
    $base_dir = __DIR__ . '/../src/';

    if (strncmp($class, $prefix, strlen($prefix)) !== 0) {
        return;
    }
    $rel = substr($class, strlen($prefix));
    $file = $base_dir . str_replace('\\', '/', $rel) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

// 4) Helperi (ručno učitaj jer nisu pod App\*)
require __DIR__ . '/../src/Helpers/functions.php';

// 5) Konfiguracija i DB
$config = require __DIR__ . '/../config/config.php';

// Ako si projekt stavio u podfolder (npr. http://localhost/OOP/Public),
// postavi base_url u configu npr. '/OOP/Public'
use App\Core\Database;
use App\Controllers\TaskController;

// Fallback ako autoload nije našao Database (npr. pogrešna struktura)
if (!class_exists(\App\Core\Database::class)) {
    die('Autoload problem: provjeri da li postoji /src/Core/Database.php sa namespace App\Core;');
}

$db = Database::getConnection($config);

// 6) Routing
$action = $_GET['action'] ?? 'index';
$controller = new TaskController($db);

switch ($action) {
    case 'store':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') $controller->store();
        break;
    case 'update':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') $controller->update();
        break;
    case 'destroy':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') $controller->destroy();
        break;
    case 'toggle':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') $controller->toggle();
        break;
    case 'complete':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') $controller->complete();
        break;
    case 'reopen':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') $controller->reopen();
        break;
    default:
        $controller->index();
}
