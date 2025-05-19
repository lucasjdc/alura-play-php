<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Entity\Video;
use Alura\Mvc\Repository\VideosRepository;

class EditVideoController
{
    public function __construct(private VideosRepository $videoRepository)    
    {
    }

    public function processaRequisicao(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id === false || $id === null) {
            header('Location: /?sucesso=0');
            return;
        }

        $url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
        if ($url === false) {
            header('Location: /?sucesso=0');
            return;
        }

        $titulo = filter_input(INPUT_POST, 'titulo');
        if ($titulo === false || empty($titulo)) {
            header('Location: /?sucesso=0');
            return;
        }

        $video = new Video($url, $titulo);
        $video->setId($id);

        $this->videoRepository->update($video);
        header('Location: /?sucesso=1');
    }
}
