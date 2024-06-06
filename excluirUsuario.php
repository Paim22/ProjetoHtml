<?php
// Configurações do banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "projeto_login";

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$message = "";

// Lógica para exclusão de usuário por ID
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['delete_id'])) {
    $delete_id = $_POST['delete_id'];

    // Preparar a declaração para evitar SQL Injection
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id_usuario = ?");
    if ($stmt === false) {
        $message = "Erro na preparação: " . htmlspecialchars($conn->error);
    } else {
        $stmt->bind_param("i", $delete_id); // "i" indica que o parâmetro é um inteiro

        // Verifica se a execução foi bem sucedida
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $message = "Usuário excluído com sucesso.";
            } else {
                $message = "Usuário com ID " . htmlspecialchars($delete_id) . " não encontrado.";
            }
        } else {
            $message = "Erro ao excluir: " . htmlspecialchars($stmt->error);
        }

        // Fecha a declaração
        $stmt->close();
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="utf-8">
    <title>Exclusão de Usuários</title>
    <link rel="stylesheet" href="style/main.css">
    <link rel="shortcut icon" href="imagens/icon/faicon.jpg">
</head>
<body>
    <h1>Exclusão de Usuário</h1>
    <?php if (!empty($message)) { echo "<p>{$message}</p>"; } ?>
    <form method="POST" action="">
        <h2>ID do usuário a ser excluído:</h2>
        <input type="number" name="delete_id" required><br>
        <input type="submit" value="Excluir">
    </form>
    <div id="cortes">
        <a href="sair.php">Sair</a>
    </div>
    <div id="cortes">
        <a href="areaPrivada.php">Área Privada</a>
    </div>
</body>
</html>
