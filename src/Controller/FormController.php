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
        $video = [
            'url' => '',
            'title' => '',
        ];

        if ($id !== false && $id !== null) {
            $videoEntity = $this->repository->findById($id);
            if ($videoEntity !== null) {
                $video = [
                    'url' => $videoEntity->getUrl(),
                    'title' => $videoEntity->getTitle(),
                ];
            }
        }

        require_once __DIR__ . '/../../video-form.php';
    }
}