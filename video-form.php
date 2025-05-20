<?php

/** @var array $videoData */
?>
<?php require_once 'inicio-html.php'; ?>

    <nav class="cabecalho">
        <a class="logo" href="/"></a>

        <div class="cabecalho__icones">
            <a href="/novo-video" class="cabecalho__videos"></a>
            <a href="../pages/login.html" class="cabecalho__sair">Sair</a>
        </div>
    </nav>

</header>

<main class="container">

    <form class="container__formulario"
          method="post">
        <h2 class="formulario__titulo"><?= isset($videoData['id']) ? 'Editar Vídeo' : 'Envie um vídeo!'; ?></h2>
            <div class="formulario__campo">
                <label class="campo__etiqueta" for="url">Link embed</label>
                <input name="url"
                       value="<?= htmlspecialchars($videoData['url']); ?>"
                       class="campo__escrita"
                       required
                       placeholder="Por exemplo: https://www.youtube.com/embed/FAY1K2aUg5g"
                       id='url' />
            </div>


            <div class="formulario__campo">
                <label class="campo__etiqueta" for="titulo">Titulo do vídeo</label>
                <input name="titulo"
                       value="<?= htmlspecialchars($videoData['title']); ?>"
                       class="campo__escrita"
                       required
                       placeholder="Neste campo, dê o nome do vídeo"
                       id='titulo' />
            </div>

            <?php if (isset($videoData['id'])): ?>
                <input type="hidden" name="id" value="<?= $videoData['id'] ?>">
            <?php endif; ?>

            <input class="formulario__botao" type="submit" value="Enviar" />
    </form>

</main>
<?php require_once 'fim-html.php'; ?>