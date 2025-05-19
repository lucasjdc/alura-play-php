<?php

declare(strict_types=1);

namespace Alura\Mvc\Repository;

use Alura\Mvc\Entity\Video;
use PDO;
use PDOException;
use RuntimeException;

class VideosRepository
{
    public function __construct(private PDO $pdo)
    {
    }

    public function add(Video $video): bool
    {
        try {
            $sql = 'INSERT INTO videos (url, title) VALUES (?, ?)';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(1, $video->getUrl());
            $stmt->bindValue(2, $video->getTitle());

            $ok = $stmt->execute();

            if ($ok) {
                $video->setId((int) $this->pdo->lastInsertId());
            }

            return $ok;
        } catch (PDOException $e) {
            throw new RuntimeException('Erro ao adicionar vídeo: ' . $e->getMessage(), 0, $e);
        }
    }

    public function remove(int $id): bool
    {
        try {
            $stmt = $this->pdo->prepare('DELETE FROM videos WHERE id = ?');
            $stmt->bindValue(1, $id, PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            throw new RuntimeException('Erro ao remover vídeo: ' . $e->getMessage(), 0, $e);
        }
    }

    public function update(Video $video): bool
    {
        try {
            $sql = 'UPDATE videos SET url = :url, title = :title WHERE id = :id';
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindValue(':url', $video->getUrl());
            $stmt->bindValue(':title', $video->getTitle());
            $stmt->bindValue(':id', $video->getId(), PDO::PARAM_INT);
            $stmt->execute();

            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            throw new RuntimeException('Erro ao atualizar vídeo: ' . $e->getMessage(), 0, $e);
        }
    }

    /** @return Video[] */
    public function all(): array
    {
        try {
            $stmt = $this->pdo->query('SELECT id, url, title FROM videos');
            $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

            return array_map(static function (array $data): Video {
                $url = $data['url'] ?? '';
                $title = $data['title'] ?? 'Sem título';

                if (empty($url) || !is_string($url) || !is_string($title)) {
                    throw new RuntimeException("Dados inválidos no banco de dados");
                }

                $video = new Video($url, $title);
                $video->setId((int) $data['id']);
                return $video;
            }, $rows);
        } catch (PDOException $e) {
            throw new RuntimeException('Erro ao listar vídeos: ' . $e->getMessage(), 0, $e);
        }
    }

    public function iterateAll(): \Generator
    {
        $stmt = $this->pdo->query('SELECT id, url, title FROM videos');
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $url = $row['url'] ?? '';
            $title = $row['title'] ?? 'Sem título';

            if (empty($url) || !is_string($url) || !is_string($title)) {
                continue; // ou yield null, ou logar
            }

            $video = new Video($url, $title);
            $video->setId((int) $row['id']);
            yield $video;
        }
    }

    public function findById(int $id): ?Video
    {
        $stmt = $this->pdo->prepare('SELECT id, url, title FROM videos WHERE id = ?');
        $stmt->bindValue(1, $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$row) {
            return null;
        }

        $url = $row['url'] ?? '';
        $title = $row['title'] ?? 'Sem título';

        if (empty($url) || !is_string($url) || !is_string($title)) {
            return null;
        }

        $video = new Video($url, $title);
        $video->setId((int) $row['id']);
        return $video;
    }
}