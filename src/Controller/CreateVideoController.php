<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideosRepository;

class CreateVideoController
{
    public function __construct(private VideosRepository $repository)
    {
    }

    public function processaRequisicao(): void
    {
        $url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
        $titulo = filter_input(INPUT_POST, 'titulo');

        if ($url === false || $titulo === false) {
            header('Location: /?sucesso=0');
            exit();
        }

        $video = new Video($url, $titulo);

        if ($this->repository->add($video) === false) {
            header('Location: /?sucesso=0');
            exit();
        } else {
            header('Location: /?sucesso=1');
            exit();
        }
    }
}
