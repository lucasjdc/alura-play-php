<?php

declare(strict_types=1);
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use Alura\Mvc\Controller\CreateVideoController;
use Alura\Mvc\Controller\DeleteVideoController;
use Alura\Mvc\Controller\EditVideoController;
use Alura\Mvc\Controller\Error404Controller;
use Alura\Mvc\Controller\FormController;
use Alura\Mvc\Controller\VideoListController;
use Alura\Mvc\Repository\VideosRepository;

require_once __DIR__ . '/../vendor/autoload.php';

$dbPath = __DIR__ . '/../banco.sqlite';
$pdo = new PDO("sqlite:$dbPath");
$videoRepository = new VideosRepository($pdo);

if (empty($_SERVER['PATH_INFO']) || $_SERVER['PATH_INFO'] === '/') {
    $controller = new VideoListController($videoRepository);
    $controller->processaRequisicao();

} elseif ($_SERVER['PATH_INFO'] === '/novo-video') {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $controller = new FormController($videoRepository);
        $controller->processaRequisicao();
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller = new CreateVideoController($videoRepository);
        $controller->processaRequisicao();
    }
} elseif ($_SERVER['PATH_INFO'] === '/editar-video') {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        require_once __DIR__ . '/../video-form.php';
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $controller = new EditVideoController($videoRepository);
        $controller->processaRequisicao();
    }
} elseif ($_SERVER['PATH_INFO'] === '/remover-video') {
    $controller = new DeleteVideoController($videoRepository);
    $controller->processaRequisicao();
} else {
    $controller = new Error404Controller();
    $controller->processaRequisicao();
}