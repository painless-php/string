<?php

/* Report all errors to help noticing deprecation errors etc. */
error_reporting(E_ALL);

/* Load .env configuration for testing */
$envDir = dirname(__DIR__);

if(is_file($envDir . '/.env')) {
    $dotenv = Dotenv\Dotenv::createImmutable($envDir);
    $dotenv->load();
}

if(! function_exists('env')) {
    function env(string $key, $default = null)
    {
        return $_ENV[$key] ?? $default;
    }
}
