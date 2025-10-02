<?php
// src/Helpers/functions.php

function base_url(string $path = ''): string {
    static $cfg = null;
    if ($cfg === null) {
        $cfg = require __DIR__ . '/../../config/config.php';
    }

    // Ako je u configu eksplicitno postavljen base_url — koristi ga
    $base = trim((string)($cfg['app']['base_url'] ?? ''), '/');

    if ($base === '') {
        // Izračunaj iz konteksta: npr. kad radiš "php -S localhost:8080 -t Public"
        // SCRIPT_NAME je tipično "/index.php", a dir je "/"
        $scriptDir = rtrim(str_replace('\\','/', dirname($_SERVER['SCRIPT_NAME'] ?? '/')), '/');
        if ($scriptDir === '' || $scriptDir === '.' || $scriptDir === '\\') {
            $base = ''; // root
        } else {
            $base = ltrim($scriptDir, '/');
        }
    }

    $prefix = $base === '' ? '' : '/' . $base;
    $path = ltrim($path, '/');

    return $prefix . ($path !== '' ? '/' . $path : ($prefix === '' ? '/' : ''));
}

/**
 * HTTP redirect helper
 * - koristi 303 See Other da natjera browser na GET nakon POST-a
 * - Location uvijek bude apsolutna staza (od korijena), ne prazna
 */
function redirect(string $to = ''): void {
    $location = base_url($to);
    if ($location === '' || $location[0] !== '/') {
        $location = '/' . ltrim($location, '/');
    }
    header('Location: ' . $location, true, 303);
    exit;
}

function e(?string $val): string {
    return htmlspecialchars($val ?? '', ENT_QUOTES, 'UTF-8');
}
