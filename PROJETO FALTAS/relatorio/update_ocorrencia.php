<?php
session_start();
require 'conexao.php'; // Conexão utilizando PDO

// Verifica se o ID da ocorrência foi passado na URL
if (!isset($_GET['id']) || !isset($_GET['entidade'])) {
    header('Location: relatorio.php'); // Redireciona se o ID ou a entidade não foram passados
    exit;
}

$id_ocorrencia = $_GET['id']; // ID da ocorrência
$entidade = $_GET['entidade']; // 'funcionario' ou 'aluno'
$tabela = $entidade === 'funcionario' ? 'funcionario' : 'aluno';
$id_campo_ocorrencia = $entidade === 'funcionario' ? 'id_funcionario' : 'id_aluno';

// Consulta para obter as informações da ocorrência
$sql = "
    SELECT ocorrencia.*, $tabela.nome 
    FROM ocorrencia 
    LEFT JOIN $tabela ON $tabela.id_$entidade = ocorrencia.$id_campo_ocorrencia
    WHERE ocorrencia.id_ocorrencia = :id_ocorrencia";

$stmt = $conexao->prepare($sql);
$stmt->bindParam(':id_ocorrencia', $id_ocorrencia, PDO::PARAM_INT);
$stmt->execute();
$ocorrencia = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$ocorrencia) {
    header('Location: relatorio.php'); // Se a ocorrência não existir, redireciona
    exit;
}

// Processa o formulário de edição
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $tipo_ocorrencia = trim($_POST['tipo_ocorrencia']);
    $descricao = trim($_POST['descricao']);
    $justificativa = trim($_POST['justificativa']);

    // Validação dos campos obrigatórios
    if (empty($tipo_ocorrencia) || empty($descricao) || empty($justificativa)) {
        $_SESSION['mensagem'] = 'Todos os campos são obrigatórios.';
        header('Location: edit_ocorrencia.php?id=' . $id_ocorrencia . '&entidade=' . $entidade);
        exit;
    }

    // Atualiza as informações da ocorrência no banco
    $sql_update = "
        UPDATE ocorrencia
        SET tipo_ocorrencia = :tipo_ocorrencia, descricao = :descricao, justificativa = :justificativa
        WHERE id_ocorrencia = :id_ocorrencia";

    $stmt_update = $conexao->prepare($sql_update);
    $stmt_update->bindParam(':tipo_ocorrencia', $tipo_ocorrencia);
    $stmt_update->bindParam(':descricao', $descricao);
    $stmt_update->bindParam(':justificativa', $justificativa);
    $stmt_update->bindParam(':id_ocorrencia', $id_ocorrencia, PDO::PARAM_INT);

    if ($stmt_update->execute()) {
        $_SESSION['mensagem'] = 'Ocorrência atualizada com sucesso!';
        header('Location: relatorio.php'); // Redireciona para a página index
        exit;
    } else {
        $_SESSION['mensagem'] = 'Erro ao atualizar ocorrência!';
    }
}
?>
