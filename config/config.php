<?php
// config/config.php
return [
    'db' => [
        'dsn'  => 'mysql:host=127.0.0.1;dbname=todo_app;charset=utf8mb4',
        'user' => 'root',
        'pass' => '',
        'options' => [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ],
    ],
    'app' => [
        'base_url' => '/', // postavi na npr. '/todo-php-pdo/public/' ako je u podfolderu
    ],
];