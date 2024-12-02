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
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Ocorrência</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <?php include('../navbar.php'); ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Editar Ocorrência - <?= htmlspecialchars($ocorrencia['nome']) ?>
                            <a href="relatorio.php?entidade=<?= htmlspecialchars($entidade) ?>" class="btn btn-danger float-end">Voltar</a>
                        </h4>
                    </div>
                    <div class="card-body">
                        <?php
                        if (isset($_SESSION['mensagem'])) {
                            echo "<div class='alert alert-info'>{$_SESSION['mensagem']}</div>";
                            unset($_SESSION['mensagem']);
                        }
                        ?>
                        <form method="POST" action="update_ocorrencia.php">
                            <div class="mb-3">
                                <label for="tipo_ocorrencia" class="form-label">Tipo de Ocorrência</label>
                                <select name="tipo_ocorrencia" id="tipo_ocorrencia" class="form-control" required>
                                    <option value="Falta" <?= $ocorrencia['tipo_ocorrencia'] == 'Falta' ? 'selected' : '' ?>>Falta</option>
                                    <option value="Atraso" <?= $ocorrencia['tipo_ocorrencia'] == 'Atraso' ? 'selected' : '' ?>>Atraso</option>
                                    <option value="Justificativa" <?= $ocorrencia['tipo_ocorrencia'] == 'Justificativa' ? 'selected' : '' ?>>Justificativa</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="descricao" class="form-label">Descrição</label>
                                <textarea name="descricao" id="descricao" class="form-control" rows="4" required><?= htmlspecialchars($ocorrencia['descricao']) ?></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="justificativa" class="form-label">Justificativa</label>
                                <textarea name="justificativa" id="justificativa" class="form-control" rows="4"><?= htmlspecialchars($ocorrencia['justificativa']) ?></textarea>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary">Atualizar Ocorrência</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <
