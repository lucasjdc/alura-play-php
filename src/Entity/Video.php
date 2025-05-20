<?php

declare(strict_types=1);

namespace Alura\Mvc\Entity;

/**
 * Representa a entidade de um vídeo na aplicação.
 */
class Video
{
    /**
     * Identificador único do vídeo no banco de dados.
     * Pode ser nulo até o vídeo ser persistido.
     *
     * @var ?int
     */
    private ?int $id = null;

    /**
     * URL do vídeo. Deve ser uma URL válida.
     *
     * @var string
     */
    private string $url;

    /**
     * Título do vídeo.
     *
     * @var string
     */
    private string $title;

    /**
     * Construtor da classe Video.
     * Inicializa um novo objeto Video com a URL e o título fornecidos.
     *
     * @param string $url URL do vídeo.
     * @param string $title Título do vídeo.
     */
    public function __construct(string $url, string $title)
    {
        $this->setUrl($url);
        $this->title = $title;
    }

    /**
     * Define a URL do vídeo, validando se é uma URL válida.
     *
     * @param string $url A URL a ser definida.
     * @throws \InvalidArgumentException Se a URL fornecida não for válida.
     * @return void
     */
    public function setUrl(string $url): void
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new \InvalidArgumentException("URL inválida: $url");
        }
        $this->url = $url;
    }

    /**
     * Define o título do vídeo.
     *
     * @param string $title O título a ser definido.
     * @return void
     */
    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    /**
     * Define o ID do vídeo. Geralmente usado pelo repositório após a persistência.
     *
     * @param int $id O ID a ser definido.
     * @return void
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * Retorna o ID do vídeo. Pode ser nulo se o vídeo ainda não foi persistido.
     *
     * @return ?int O ID do vídeo ou null.
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Retorna a URL do vídeo.
     *
     * @return string A URL do vídeo.
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * Retorna o título do vídeo.
     *
     * @return string O título do vídeo.
     */
    public function getTitle(): string
    {
        return $this->title;
    }
}