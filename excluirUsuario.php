<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "seu_banco_de_dados";

// Conexão com o banco de dados
$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica a conexão
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verifica se o usuário já existe
    $sql = "SELECT * FROM usuarios WHERE nome='$nome'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "<script>alert('Usuário já existe.');</script>";
    } else {
        // Insere o novo usuário
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')";
        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Usuário cadastrado com sucesso.');</script>";
        } else {
            echo "<script>alert('Erro ao cadastrar: " . $conn->error . "');</script>";
        }
    }
}

// Código para exclusão de usuário
if (isset($_GET['delete_nome'])) {
    $delete_nome = $_GET['delete_nome'];
    $sql = "DELETE FROM usuarios WHERE nome='$delete_nome'";
    if ($conn->query($sql) === TRUE) {
        echo "
        <script>
            alert('Usuário excluído com sucesso.');
            if (confirm('Deseja excluir outro usuário?')) {
                // O usuário escolhe excluir outro usuário
                window.location.href = window.location.pathname;
            } else {
                // O usuário escolhe não excluir outro usuário
                window.location.href = 'areaPrivada.php';
            }
        </script>";
    } else {
        echo "<script>alert('Erro ao excluir: " . $conn->error . "');</script>";
    }
}

$conn->close();
?>