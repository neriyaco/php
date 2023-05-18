<?php

if (!defined('GUARD')) {
    header('HTTP/1.1 404 Not Found');
    exit;
}

function parseEnv($filePath = '.env')
{
    $data = [];
    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        if (strpos($line, '=') !== false && strpos($line, '#') !== 0) {
            list($name, $value) = explode('=', $line, 2);
            $name = trim($name);
            $value = trim($value);
            $data[$name] = $value;
            putenv("$name=$value");
        }
    }

    return $data;
}
