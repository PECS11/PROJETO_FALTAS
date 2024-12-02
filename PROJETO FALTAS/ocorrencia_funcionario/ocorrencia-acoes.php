<?php
session_start();
require 'conexao.php'; // Conexão utilizando PDO

// Inserção de ocorrência para funcionário
if (isset($_POST['create_ocorrencia'])) {
    // Captura os dados do formulário
    $tipo_ocorrencia = trim($_POST['tipo_ocorrencia']);
    $id_funcionario = trim($_POST['id_funcionario']); // Agora usando id_funcionario
    $data = trim($_POST['data_oco']);
    $descricao = trim($_POST['descricao']);
    $justificativa = trim($_POST['justificativa']);

    // Validação dos campos obrigatórios
    if (empty($tipo_ocorrencia) || empty($id_funcionario) || empty($data) || empty($descricao) || empty($justificativa)) {
        $_SESSION['mensagem'] = "Todos os campos são obrigatórios. Por favor, preencha todos os dados.";
        header('Location: ocorrenciaf.php');
        exit;
    }

    // Prepara a query de inserção
    $sql = "INSERT INTO ocorrencia (tipo_ocorrencia, id_funcionario, data_oco, descricao, justificativa) 
            VALUES (:tipo_ocorrencia, :id_funcionario, :data_oco, :descricao, :justificativa)";

    try {
        // Prepara a consulta
        $stmt = $conexao->prepare($sql);

        // Executa com os parâmetros
        $stmt->execute([
            ':tipo_ocorrencia' => $tipo_ocorrencia,
            ':id_funcionario' => $id_funcionario, // Usando id_funcionario agora
            ':data_oco' => $data,
            ':descricao' => $descricao,
            ':justificativa' => $justificativa,
        ]);

        // Verifica a inserção
        if ($stmt->rowCount() > 0) {
            $_SESSION['mensagem'] = "Ocorrência criada com sucesso!";
        } else {
            $_SESSION['mensagem'] = "Ocorrência não foi criada.";
        }

        // Redireciona
        header('Location: ocorrenciaf.php');
        exit;
    } catch (PDOException $e) {
        $_SESSION['mensagem'] = "Erro ao inserir ocorrência: " . $e->getMessage();
        header('Location: ocorrenciaf.php');
        exit;
    }
}

// Atualização de ocorrência para funcionário
if (isset($_POST['update_ocorrencia'])) {
    $id_ocorrencia = $_POST['id_ocorrencia'];
    $tipo_ocorrencia = trim($_POST['tipo_ocorrencia']);
    $id_funcionario = trim($_POST['id_funcionario']); // Usando id_funcionario
    $data_oco = trim($_POST['data_oco']);
    $descricao = trim($_POST['descricao']);
    $justificativa = trim($_POST['justificativa']);

    // Validação dos campos obrigatórios
    if (empty($tipo_ocorrencia) || empty($id_funcionario) || empty($data_oco) || empty($descricao) || empty($justificativa)) {
        $_SESSION['mensagem'] = "Todos os campos são obrigatórios.";
        header('Location: edit_ocorrencia.php?id=' . $id_ocorrencia);
        exit;
    }

    // Atualiza os dados da ocorrência
    $sql = "UPDATE ocorrencia 
            SET tipo_ocorrencia = :tipo_ocorrencia, 
                id_funcionario = :id_funcionario, 
                data_oco = :data_oco, 
                descricao = :descricao, 
                justificativa = :justificativa 
            WHERE id_ocorrencia = :id_ocorrencia";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':tipo_ocorrencia', $tipo_ocorrencia);
    $stmt->bindParam(':id_funcionario', $id_funcionario); // Usando id_funcionario
    $stmt->bindParam(':data_oco', $data_oco);
    $stmt->bindParam(':descricao', $descricao);
    $stmt->bindParam(':justificativa', $justificativa);
    $stmt->bindParam(':id_ocorrencia', $id_ocorrencia);

    if ($stmt->execute()) {
        $_SESSION['mensagem'] = "Ocorrência atualizada com sucesso!";
        header('Location: ocorrenciaf.php');
        exit;
    } else {
        $_SESSION['mensagem'] = "Erro ao atualizar a ocorrência.";
        header('Location: edit_ocorrencia.php?id=' . $id_ocorrencia);
        exit;
    }
}

// Deleção de ocorrência para funcionário
if (isset($_POST['delete_ocorrencia'])) {
    // Captura o id da ocorrência a ser deletada
    $ocorrencia_id = $_POST['delete_ocorrencia'];

    // Prepara a consulta de deleção
    $sql = "DELETE FROM ocorrencia WHERE id_ocorrencia = :ocorrencia_id";

    try {
        // Preparando a consulta
        $stmt = $conexao->prepare($sql);

        // Vinculando o parâmetro
        $stmt->bindParam(':ocorrencia_id', $ocorrencia_id, PDO::PARAM_INT);

        // Executando a consulta
        if ($stmt->execute()) {
            $_SESSION['mensagem'] = 'Ocorrência deletada com sucesso';
        } else {
            $_SESSION['mensagem'] = 'Ocorrência não foi deletada';
        }
    } catch (PDOException $e) {
        $_SESSION['mensagem'] = "Erro ao deletar ocorrência: " . $e->getMessage();
    }

    // Redirecionando de volta
    header('Location: ocorrenciaf.php');
    exit;
}
?>
