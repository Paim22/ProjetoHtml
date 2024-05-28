<?php

class Usuarios {
    private $pdo;
    public $msgERRO = ""; // variável que vai receber mensagens de erro

    public function conectar($nome, $host, $usuario, $senha) {
        global $pdo;
        global $msgERRO;
        try {
            $pdo = new PDO("mysql:dbname=".$nome.";host=".$host, $usuario, $senha);
        } catch (PDOException $e) {
            $msgERRO = $e->getMessage();
        }
    }

    public function cadastrar($nome, $telefone, $email, $senha, $cpf) {
        global $pdo;
        // Verificar se já existe o email ou CPF cadastrado
        $sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :e OR cpf = :c");
        $sql->bindValue(":e", $email);
        $sql->bindValue(":c", $cpf);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            return false; // Já está cadastrado
        } else {
            // Caso não, cadastrar
            $sql = $pdo->prepare("INSERT INTO usuarios (nome, telefone, email, senha, cpf) VALUES (:n, :t, :e, :s, :c)");
            $sql->bindValue(":n", $nome);
            $sql->bindValue(":t", $telefone);
            $sql->bindValue(":e", $email);
            $sql->bindValue(":s", md5($senha)); // Use uma forma mais segura de hash para senhas em produção, como password_hash
            $sql->bindValue(":c", $cpf);
            $sql->execute();
            return true;
        }
    }

    public function logar($email, $senha) {
        global $pdo;
        // Verificar se o email e senha estão cadastrados, ou seja, se existem (e são válidos)
        $sql = $pdo->prepare("SELECT id_usuario FROM usuarios WHERE email = :e AND senha = :s");
        $sql->bindValue(":e", $email);
        $sql->bindValue(":s", md5($senha)); // Use password_hash na hora de armazenar e password_verify na verificação
        $sql->execute();
        if ($sql->rowCount() > 0) {
            // Entrar no sistema (sessão)
            $dado = $sql->fetch();
            session_start();
            $_SESSION['id_usuario'] = $dado['id_usuario'];
            return true; // Logado com sucesso
        } else {
            return false; // Não foi possível logar
        }
    }

    public function atualizarInformacoes($usuarioAtual, $novoNome, $novoEmail, $novaSenha, $novoTelefone) {
        global $pdo;
        $sql = $pdo->prepare("UPDATE usuarios SET nome = :nn, email = :ne, senha = :ns, telefone = :nt WHERE nome = :n");
        $sql->bindValue(":nn", $novoNome);
        $sql->bindValue(":ne", $novoEmail);
        $sql->bindValue(":ns", md5($novaSenha)); // Supondo que a senha seja criptografada com md5
        $sql->bindValue(":nt", $novoTelefone);
        $sql->bindValue(":n", $usuarioAtual);
        return $sql->execute(); // Retorna true se a atualização foi bem-sucedida
    }
    
    public function buscarInformacoes($usuarioAtual) {
        global $pdo;
        $sql = $pdo->prepare("SELECT * FROM usuarios WHERE nome = :n");
        $sql->bindValue(":n", $usuarioAtual);
        $sql->execute();
        if ($sql->rowCount() > 0) {
            return $sql->fetch();
        } else {
            return false;
        }
    }
}
?>
