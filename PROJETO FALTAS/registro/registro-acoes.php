<?php
session_start();
require 'conexao.php'; // Conexão utilizando PDO

if (isset($_POST['create_registro'])) {
    // Prepara os dados recebidos via POST
    $nome = trim($_POST['nome']);
    $sobrenome = trim($_POST['sobrenome']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);

    // Validação dos campos obrigatórios
    if (empty($nome) || empty($sobrenome) || empty($email) || empty($senha)) {
        $_SESSION['mensagem'] = "Todos os campos são obrigatórios. Por favor, preencha todos os dados.";
        header('Location: registros.php');
        exit;
    }

    // Validação de e-mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['mensagem'] = "Por favor, insira um e-mail válido.";
        header('Location: registros.php');
        exit;
    }

    // Criptografando a senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Prepara a query com placeholders para evitar SQL Injection
    $sql = "INSERT INTO registro (nome, sobrenome, email, senha) 
            VALUES (:nome, :sobrenome, :email, :senha)";
    
    try {
        // Prepara o statement
        $stmt = $conexao->prepare($sql);

        // Executa a query com os parâmetros
        $stmt->execute([
            ':nome' => $nome,
            ':sobrenome' => $sobrenome,
            ':email' => $email,
            ':senha' => $senha_hash, // Usando a senha criptografada
        ]);

        // Verifica se a inserção afetou alguma linha
        if ($stmt->rowCount() > 0) {
            $_SESSION['mensagem'] = "Registro criado com sucesso";
        } else {
            $_SESSION['mensagem'] = "Registro não foi criado";
        }

        // Redireciona para a página inicial
        header('Location: registros.php');
        exit;
    } catch (PDOException $e) {
        // Captura erros e define uma mensagem
        $_SESSION['mensagem'] = "Erro ao inserir Registro: " . $e->getMessage();
        header('Location: registros.php');
        exit;
    }
}

if (isset($_POST['update_registro'])) {

    // Captura dos dados do formulário
    $registro_id = $_POST['registro_id'];
    $nome = trim($_POST['nome']);
    $sobrenome = trim($_POST['sobrenome']);
    $email = trim($_POST['email']);
    $senha = trim($_POST['senha']);
    
    // Validação dos campos obrigatórios
    if (empty($nome) || empty($sobrenome) || empty($email) || empty($senha)) {
        $_SESSION['mensagem'] = "Todos os campos são obrigatórios. Por favor, preencha todos os dados.";
        header('Location: registros.php');
        exit;
    }

    // Validação de e-mail
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['mensagem'] = "Por favor, insira um e-mail válido.";
        header('Location: registros.php');
        exit;
    }

    // Criptografando a senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    // Prepara a consulta de atualização com parâmetros nomeados
    $sql = "UPDATE registro SET nome = :nome, sobrenome = :sobrenome, email = :email, senha = :senha WHERE id_registro = :registro_id";
    
    // Preparando a consulta
    $stmt = $conexao->prepare($sql);
    
    // Vinculando os parâmetros
    $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
    $stmt->bindParam(':sobrenome', $sobrenome, PDO::PARAM_STR);
    $stmt->bindParam(':email', $email, PDO::PARAM_STR);
    $stmt->bindParam(':senha', $senha_hash, PDO::PARAM_STR); // Usando a senha criptografada
    $stmt->bindParam(':registro_id', $registro_id, PDO::PARAM_INT);
    
    // Executando a consulta
    if ($stmt->execute()) {
        $_SESSION['mensagem'] = 'Registro atualizado com sucesso';
    } else {
        $_SESSION['mensagem'] = 'Registro não foi atualizado';
    }
    
    // Redirecionando de volta
    header('Location: registros.php');
    exit;
}

if (isset($_POST['delete_registro'])) {

    // Captura o id do registro a ser deletado
    $registro_id = $_POST['delete_registro'];

    // Prepara a consulta de deleção
    $sql = "DELETE FROM registro WHERE id_registro = :registro_id";

    // Preparando a consulta
    $stmt = $conexao->prepare($sql);

    // Vinculando o parâmetro
    $stmt->bindParam(':registro_id', $registro_id, PDO::PARAM_INT);

    // Executando a consulta
    if ($stmt->execute()) {
        $_SESSION['mensagem'] = 'Registro deletado com sucesso';
    } else {
        $_SESSION['mensagem'] = 'Registro não foi deletado';
    }

    // Redirecionando de volta
    header('Location: registros.php');
    exit;
}
?>
