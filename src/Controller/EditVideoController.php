<?php

namespace Alura\Mvc\Controller;

use Alura\Mvc\Repository\VideosRepository;

class EditVideoController
{
    public function __construct(private VideosRepository $videoRepository)
    {
    }

    public function processaRequisicao(): void
    {
        // Este método pode ser mantido vazio ou redirecionar para uma ação padrão
        // dependendo da sua lógica geral. As ações específicas (exibeFormulario e
        // processaEdicao) serão chamadas diretamente no index.php.
    }

    public function exibeFormulario(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if ($id === false || $id === null) {
            header('Location: /?sucesso=0');
            exit;
        }

        $video = $this->videoRepository->findById($id);
        if ($video === null) {
            http_response_code(404);
            echo "Vídeo não encontrado.";
            return;
        }

        // Incluir o arquivo de visualização (form) passando os dados do vídeo
        require_once __DIR__ . '/../../video-form.php';
    }

    public function processaEdicao(): void
    {
        $id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT); // Recebe o ID do formulário
        if ($id === false || $id === null) {
            header('Location: /?sucesso=0');
            exit;
        }

        $video = $this->videoRepository->findById($id);
        if ($video === null) {
            http_response_code(404);
            echo "Vídeo não encontrado.";
            return;
        }

        $url = filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL);
        if ($url === false) {
            header('Location: /?sucesso=0');
            exit;
        }

        $titulo = filter_input(INPUT_POST, 'titulo');
        if ($titulo === false || empty($titulo)) {
            header('Location: /?sucesso=0');
            exit;
        }

        $video->setUrl($url);
        $video->setTitle($titulo);

        $this->videoRepository->update($video);

        header('Location: /?sucesso=1');
        exit;
    }
}
