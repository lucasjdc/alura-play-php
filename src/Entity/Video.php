<?php

declare(strict_types=1);

namespace Alura\Mvc\Entity;

class Video
{
    private int $id;
    private string $url;
    private string $title;

    public function __construct(string $url, string $title)
    {
        $this->setUrl($url);
        $this->title = $title;
    }

    private function setUrl(string $url): void
    {
        if (filter_var($url, FILTER_VALIDATE_URL) === false) {
            throw new \InvalidArgumentException("URL inválida: $url");
        }
        $this->url = $url;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    public function getTitle(): string
    {
        return $this->title;
    }
}
