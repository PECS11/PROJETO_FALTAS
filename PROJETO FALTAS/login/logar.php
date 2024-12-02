<?php
session_start();
require 'conexao.php'; // Inclua a conexão com o banco de dados PDO

// Verificar se o formulário foi enviado
if (isset($_POST['email']) && isset($_POST['senha'])) {
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);
    
    // Validar se os campos estão preenchidos
    if (empty($email) || empty($senha)) {
        $_SESSION['mensagem'] = "Por favor, preencha todos os campos.";
        header('Location: index.php'); // Redireciona de volta para a página de login
        exit;
    }

    // Consultar o banco de dados para verificar se o e-mail existe
    $sql = "SELECT * FROM registro WHERE email = :email LIMIT 1";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->execute();
    
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        // Verificar se a senha corresponde à senha armazenada no banco
        if (password_verify($senha, $user['senha'])) {
            // Login bem-sucedido, redirecionar para a página de sucesso ou dashboard
            $_SESSION['usuario_id'] = $user['id_registro'];
            $_SESSION['usuario_nome'] = $user['nome'];
            $_SESSION['usuario_email'] = $user['email'];
            $_SESSION['mensagem'] = "Login realizado com sucesso!";
            
            // Caminho absoluto correto para redirecionamento
            header('Location: http://localhost/PROJETO%20FALTAS/aluno/aluno.php'); // Corrigido
            exit;
            
        } else {
            $_SESSION['mensagem'] = "Senha incorreta. Tente novamente.";
            header('Location: index.php'); // Redireciona de volta para a página de login
            exit;
        }
    } else {
        $_SESSION['mensagem'] = "Usuário não encontrado.";
        header('Location: index.php'); // Redireciona de volta para a página de login
        exit;
    }
} else {
    // Caso o formulário não tenha sido enviado corretamente
    $_SESSION['mensagem'] = "Método inválido.";
    header('Location: index.php'); // Redireciona de volta para a página de login
    exit;
}
?>
