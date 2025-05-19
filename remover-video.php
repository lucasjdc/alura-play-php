<?php

use Alura\Mvc\Repository\VideosRepository;

$dpPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$dpPath");

$id = $_GET['id'];
$sql = 'DELETE FROM videos WHERE id = ?';
$statement = $pdo->prepare($sql);
$statement->bindValue(1, $id);

$repository = new VideosRepository($pdo);

if ($repository->remove($id) === false) {
    header('Location: /?sucesso=0');
} else {
    header('Location: /?sucesso=1');
}