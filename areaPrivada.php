<?php
session_start();

if (!isset($_SESSION['id_usuario'])) {
    header("location: index.php");
    exit;
}

// Verifica se o usuário é um administrador
$isAdmin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'];
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Área Restrita</title>
    <link rel="stylesheet" href="style/area_privada.css">
    <link rel="shortcut icon" href="imagens/icon/paz.jpg">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<div id="user-info">
    <p>Suas Informações de Cadastro:</p>
    <a href="alterar_informacao.php">Alterar Informações</a>
    <?php if ($isAdmin): ?>
    <a href="info.php">Área Restrita</a>
    <?php if ($isAdmin): ?>
        <a href="excluir_usuario.html">Exclusão de Usuários</a>
    <?php endif; ?>
    <?php endif; ?>
</div>

<h1>Veja os Melhores Títulos</h1>
<h2>Nossa Biblioteca tem a maior variedade de Livros</h2>

<div id="livros">
    <div class="coluna">
        <div class="Carta de Pero Vaz de Caminha">
            <a href="carta_pero_decaminha.php">Carta de Pero Vaz de Caminha</a>
        </div>
        <div class="Romeu e Julieta">
            <a href="romeu_julieta.php">Romeu e Julieta</a>
        </div>
        <div class="Triste fim de Policarpo">
            <a href="triste_fim_policarpo.php">Triste fim de Policarpo</a>
        </div>
        <div class="Auto da Barda do Inferno">
            <a href="auto_barca.php">Auto da Barda do Inferno</a>
        </div>
    </div>
    <div class="coluna">
        <div class="O Quinze">
            <a href="quinze.php">O Quinze</a>
        </div>
        <div class="Morte e Vida Severina">
            <a href="morte_vida_severina.php">Morte e Vida Severina</a>
        </div>
        <div class="Vidas Seca de Graciliano Ramos">
            <a href="vida_graciliano_ramos.php">Vidas Seca de Graciliano Ramos</a>
        </div>
        <div class="O cortiço">
            <a href="cortico.php">O cortiço</a>
        </div>
    </div>
</div>

<div id="cortes">
    <a href="sair.php">Sair</a>
</div>

<footer>
    <p>&copy; Todos os direitos reservados</p>
</footer>

</body>
</html>
