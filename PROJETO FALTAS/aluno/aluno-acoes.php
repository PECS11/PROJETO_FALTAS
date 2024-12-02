<?php
session_start();
require 'conexao.php'; // Conexão utilizando PDO

// Inserção de aluno
if (isset($_POST['create_aluno'])) {
    // Prepara os dados recebidos via POST
    $nome = trim($_POST['nome']);
    $matricula = trim($_POST['matricula']);
    $data_nascimento = trim($_POST['data_nascimento']);
    $telefone = trim($_POST['telefone']);
    $id_turma = trim($_POST['id_turma']); // Captura o id_turma

    // Validação dos campos obrigatórios
    if (empty($nome) || empty($matricula) || empty($data_nascimento) || empty($telefone) || empty($id_turma)) {
        $_SESSION['mensagem'] = "Todos os campos são obrigatórios. Por favor, preencha todos os dados.";
        header('Location: aluno.php');
        exit;
    }

    // Prepara a query com placeholders para evitar SQL Injection
    $sql = "INSERT INTO aluno (nome, matricula, data_nascimento, telefone, id_turma) 
            VALUES (:nome, :matricula, :data_nascimento, :telefone, :id_turma)";
    
    try {
        // Prepara o statement
        $stmt = $conexao->prepare($sql);

        // Executa a query com os parâmetros
        $stmt->execute([
            ':nome' => $nome,
            ':matricula' => $matricula,
            ':data_nascimento' => $data_nascimento,
            ':telefone' => $telefone,
            ':id_turma' => $id_turma, // Passando id_turma para a query
        ]);

        // Verifica se a inserção afetou alguma linha
        if ($stmt->rowCount() > 0) {
            $_SESSION['mensagem'] = "Aluno criado com sucesso";
        } else {
            $_SESSION['mensagem'] = "Aluno não foi criado";
        }

        // Redireciona para a página inicial
        header('Location: aluno.php');
        exit;
    } catch (PDOException $e) {
        // Captura erros e define uma mensagem
        $_SESSION['mensagem'] = "Erro ao inserir aluno: " . $e->getMessage();
        header('Location: aluno.php');
        exit;
    }
}

// Atualização de aluno
if (isset($_POST['update_aluno'])) {
    // Captura os dados do formulário
    $aluno_id = $_POST['aluno_id'];
    $nome = trim($_POST['nome']);
    $matricula = trim($_POST['matricula']);
    $data_nascimento = trim($_POST['data_nascimento']);
    $telefone = trim($_POST['telefone']);
    $id_turma = trim($_POST['id_turma']); // Capturando id_turma

    // Prepara a consulta de atualização com parâmetros nomeados
    $sql = "UPDATE aluno SET nome = :nome, matricula = :matricula, data_nascimento = :data_nascimento, telefone = :telefone, id_turma = :id_turma WHERE id_aluno = :aluno_id";
    
    try {
        // Preparando a consulta
        $stmt = $conexao->prepare($sql);
        
        // Vinculando os parâmetros
        $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
        $stmt->bindParam(':matricula', $matricula, PDO::PARAM_STR);
        $stmt->bindParam(':data_nascimento', $data_nascimento, PDO::PARAM_STR);
        $stmt->bindParam(':telefone', $telefone, PDO::PARAM_STR);
        $stmt->bindParam(':id_turma', $id_turma, PDO::PARAM_INT); // Bind para id_turma
        $stmt->bindParam(':aluno_id', $aluno_id, PDO::PARAM_INT);
        
        // Executando a consulta
        if ($stmt->execute()) {
            $_SESSION['mensagem'] = 'Aluno atualizado com sucesso';
        } else {
            $_SESSION['mensagem'] = 'Aluno não foi atualizado';
        }
    } catch (PDOException $e) {
        $_SESSION['mensagem'] = "Erro ao atualizar aluno: " . $e->getMessage();
    }
    
    // Redirecionando de volta
    header('Location: aluno.php');
    exit;
}

// Deleção de aluno
if (isset($_POST['delete_aluno'])) {
    // Captura o id do aluno a ser deletado
    $aluno_id = $_POST['delete_aluno'];

    // Prepara a consulta de deleção
    $sql = "DELETE FROM aluno WHERE id_aluno = :aluno_id";

    try {
        // Preparando a consulta
        $stmt = $conexao->prepare($sql);

        // Vinculando o parâmetro
        $stmt->bindParam(':aluno_id', $aluno_id, PDO::PARAM_INT);

        // Executando a consulta
        if ($stmt->execute()) {
            $_SESSION['mensagem'] = 'Aluno deletado com sucesso';
        } else {
            $_SESSION['mensagem'] = 'Aluno não foi deletado';
        }
    } catch (PDOException $e) {
        $_SESSION['mensagem'] = "Erro ao deletar aluno: " . $e->getMessage();
    }

    // Redirecionando de volta
    header('Location: aluno.php');
    exit;
}
?>
