<?php

declare(strict_types=1);

$id = $_GET['io0'] ?? '';

if (!is_string($id) || $id === '') {
    http_response_code(400);
    exit('Missing ID');
}

if (!preg_match('/^[A-Za-z0-9_-]+$/', $id)) {
    http_response_code(400);
    exit('Invalid ID');
}

$file = dirname(__DIR__) . '/files/' . $id . '.html';

if (!is_file($file)) {
    http_response_code(404);
    exit('Content not found');
}

header('Content-Type: text/html; charset=utf-8');
header('X-Content-Type-Options: nosniff');

readfile($file);
