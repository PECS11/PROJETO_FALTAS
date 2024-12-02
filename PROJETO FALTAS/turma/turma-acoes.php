<?php
session_start();
require 'conexao.php'; // Conexão utilizando PDO

if (isset($_POST['create_turma'])) {
    // Prepara os dados recebidos via POST
    $nome = trim($_POST['nome']);
    $curso = trim($_POST['curso']);
    $turno = trim($_POST['turno']);

    // Validação dos campos obrigatórios
    if (empty($nome) || empty($curso) || empty($turno)) {
        $_SESSION['mensagem'] = "Todos os campos são obrigatórios. Por favor, preencha todos os dados.";
        header('Location: turma.php');
        exit;
    }

    // Prepara a query com placeholders para evitar SQL Injection
    $sql = "INSERT INTO turma (nome, curso, turno) 
            VALUES (:nome, :curso, :turno)";
    
    try {
        // Prepara o statement
        $stmt = $conexao->prepare($sql);

        // Executa a query com os parâmetros
        $stmt->execute([
            ':nome' => $nome,
            ':curso' => $curso,
            ':turno' => $turno,
        ]);

        // Verifica se a inserção afetou alguma linha
        if ($stmt->rowCount() > 0) {
            $_SESSION['mensagem'] = "Turma criada com sucesso";
        } else {
            $_SESSION['mensagem'] = "Turma não foi criada";
        }

        // Redireciona para a página inicial
        header('Location: turma.php');
        exit;
    } catch (PDOException $e) {
        // Captura erros e define uma mensagem
        $_SESSION['mensagem'] = "Erro ao inserir Turma: " . $e->getMessage();
        header('Location: turma.php');
        exit;
    }
}

if (isset($_POST['update_turma'])) {

    // Captura dos dados do formulário
    $turma_id = $_POST['turma_id'];
    $nome = trim($_POST['nome']);
    $curso = trim($_POST['curso']);
    $turno = trim($_POST['turno']);
    
    // Prepara a consulta de atualização com parâmetros nomeados
    $sql = "UPDATE turma SET nome = :nome, curso = :curso, turno = :turno WHERE id_turma = :turma_id";
    
    // Preparando a consulta
    $stmt = $conexao->prepare($sql);
    
    // Vinculando os parâmetros
    $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
    $stmt->bindParam(':curso', $curso, PDO::PARAM_STR);
    $stmt->bindParam(':turno', $turno, PDO::PARAM_STR);
    $stmt->bindParam(':turma_id', $turma_id, PDO::PARAM_INT);
    
    // Executando a consulta
    if ($stmt->execute()) {
        $_SESSION['mensagem'] = 'Turma atualizada com sucesso';
    } else {
        $_SESSION['mensagem'] = 'Turma não foi atualizada';
    }
    
    // Redirecionando de volta
    header('Location: turma.php');
    exit;
}


if (isset($_POST['delete_turma'])) {

    // Captura o id da turma a ser deletada
    $turma_id = $_POST['delete_turma'];

    // Prepara a consulta de deleção
    $sql = "DELETE FROM turma WHERE id_turma = :turma_id";

    // Preparando a consulta
    $stmt = $conexao->prepare($sql);

    // Vinculando o parâmetro
    $stmt->bindParam(':turma_id', $turma_id, PDO::PARAM_INT);

    // Executando a consulta
    if ($stmt->execute()) {
        $_SESSION['message'] = 'Turma deletada com sucesso';
    } else {
        $_SESSION['message'] = 'Turma não foi deletada';
    }

    // Redirecionando de volta
    header('Location: turma.php');
    exit;
}
?>
