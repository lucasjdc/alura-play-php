<?php

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideosRepository;

$dbPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");

$url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
if ($url === false) {
    header('Location: /?sucesso=0');
    exit();
}

$titulo = filter_input(INPUT_POST, 'titulo');
if ($titulo === false) {
    header('Location: /?sucesso=0');
    exit();
}

$repository = new VideosRepository($pdo);

if ($repository->add(new Video($url, $titulo)) === false) {
    header('Location: /?sucesso=0');    
    exit();
} else {    
    header('Location: /?sucesso=1');
    exit();
}