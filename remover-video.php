<?php

$dpPath = __DIR__ . '/banco.sqlite';
$pdo = new PDO("sqlite:$dpPath");

$id = $_GET['id'];
$sql = 'DELETE FROM videos WHERE id = ?';
$statement = $pdo->prepare($sql);
$statement->bindValue(1, $id);

if ($statement->execute() === false) {
    header('Location: /?sucesso=0');
} else {
    header('Location: /?sucesso=1');
}