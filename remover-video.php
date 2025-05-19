<?php

use Alura\Mvc\Repository\VideosRepository;

require_once __DIR__ . '/vendor/autoload.php';

$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");

$id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);

if ($id === false || $id === null) {
    header('Location: /?sucesso=0');
    exit();
}

$repository = new VideosRepository($pdo);

if ($repository->remove($id) === false) {
    header('Location: /?sucesso=0');
} else {
    header('Location: /?sucesso=1');
}
