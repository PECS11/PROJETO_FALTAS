<?php
require 'conexao.php';
session_start(); // Inicia a sessão
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lista de Ocorrências (Funcionários)</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
  </head>
  <body>
    <?php include('../navbar.php'); ?>
    <div class="container mt-4">
        <?php include('mensagem.php'); ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header"> 
                        <h4> Lista de Ocorrências (Funcionários) 
                        <a href="ocorrencia-create.php" class="btn btn-primary float-end">Adicionar Ocorrência</a>
                        </h4>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Tipo de Ocorrência</th>
                                <th>ID Funcionário</th>
                                <th>Nome Funcionário</th>
                                <th>Data</th>
                                <th>Descrição</th>
                                <th>Justificativa</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        // Buscar ocorrências que têm ID do funcionário preenchido
                        $sql = 'SELECT ocorrencia.*, funcionario.id_funcionario, funcionario.nome AS nome_funcionario
                                FROM ocorrencia
                                LEFT JOIN funcionario ON ocorrencia.id_funcionario = funcionario.id_funcionario
                                WHERE ocorrencia.id_funcionario IS NOT NULL'; // Exibe apenas ocorrências com id_funcionario

                        $stmt = $conexao->prepare($sql);
                        $stmt->execute();
                        $ocorrencias = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        if (count($ocorrencias) > 0) {
                            foreach ($ocorrencias as $ocorrencia) {
                        ?>
                        <tr>
                            <td><?= htmlspecialchars($ocorrencia['id_ocorrencia']); ?></td>
                            <td><?= htmlspecialchars($ocorrencia['tipo_ocorrencia']); ?></td>
                            <td><?= htmlspecialchars($ocorrencia['id_funcionario']); ?></td>
                            <td><?= htmlspecialchars($ocorrencia['nome_funcionario'] ? $ocorrencia['nome_funcionario'] : 'Sem Funcionário'); ?></td>
                            <td><?= date('d/m/Y', strtotime($ocorrencia['data_oco'])); ?></td>
                            <td><?= htmlspecialchars($ocorrencia['descricao']); ?></td>
                            <td><?= htmlspecialchars($ocorrencia['justificativa']); ?></td>
                            <td>
                                <a href="ocorrencia-view.php?id=<?= htmlspecialchars($ocorrencia['id_ocorrencia']); ?>" class="btn btn-secondary btn-sm">
                                    <span class="bi-eye-fill"></span>&nbsp;Visualizar
                                </a>
                                <a href="ocorrencia-edit.php?id=<?= htmlspecialchars($ocorrencia['id_ocorrencia']); ?>" class="btn btn-success btn-sm">
                                    <span class="bi-pencil-fill"></span>&nbsp;Editar
                                </a>
                                <form action="ocorrencia-acoes.php" method="POST" class="d-inline">
                                    <button type="submit" name="delete_ocorrencia" value="<?= htmlspecialchars($ocorrencia['id_ocorrencia']); ?>" class="btn btn-danger btn-sm">
                                        <span class="bi-trash3-fill"></span>&nbsp;Excluir
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <?php
                            }
                        } else {
                            echo '<tr><td colspan="8" class="text-center">Nenhuma ocorrência encontrada</td></tr>';
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"></script>
  </body>
</html>
