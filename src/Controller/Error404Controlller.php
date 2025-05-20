<?php

declare(strict_types=1);

namespace Alura\Mvc\Controller;

class Error404Controller
{
    public function processaRequisicao(): void
    {
        http_response_code(404);
        echo '<h1>Página não encontrada</h1>';
        echo '<p>A rota que você tentou acessar não existe.</p>';
        echo '<a href="/">Voltar para a página inicial</a>';
    }
}
