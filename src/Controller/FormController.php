<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideosRepository;

class FormController
{
    public function __construct(private VideosRepository $repository)
    {
    }

    public function processaRequisicao(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        $videoData = [
            'url' => '',
            'title' => '',
        ];

        if ($id !== false && $id !== null) {
            $videoEntity = $this->repository->findById($id);
            if ($videoEntity !== null) {
                $videoData = [
                    'url' => $videoEntity->getUrl(),
                    'title' => $videoEntity->getTitle(),
                    'id' => $videoEntity->getId(), // Passa o ID para a view para o campo hidden
                ];
            }
        }

        require_once __DIR__ . '/../../video-form.php';
    }
}