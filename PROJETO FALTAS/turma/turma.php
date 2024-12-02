<?php
require 'conexao.php';
session_start(); // Inicia a sessão
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrar Turma</title>
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
                    <h4>Lista de Turmas 
                        <a href="turma-create.php" class="btn btn-primary float-end">Adicionar Turma</a>
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Curso</th>
                                <th>Turno</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = 'SELECT * FROM turma';
                            $stmt = $conexao->prepare($sql);
                            $stmt->execute();
                            $turmas = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            if (count($turmas) > 0) {
                                foreach ($turmas as $turma) {
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($turma['id_turma']); ?></td>
                                <td><?= htmlspecialchars($turma['nome']); ?></td>
                                <td><?= htmlspecialchars($turma['curso']); ?></td>
                                <td><?= htmlspecialchars($turma['turno']); ?></td>
                                <td>
                                    <a href="turma-view.php?id=<?= htmlspecialchars($turma['id_turma']); ?>" class="btn btn-secondary btn-sm">
                                        <span class="bi-eye-fill"></span>&nbsp;Visualizar
                                    </a>
                                    <a href="turma-edit.php?id=<?= htmlspecialchars($turma['id_turma']); ?>" class="btn btn-success btn-sm">
                                        <span class="bi-pencil-square"></span>&nbsp;Editar
                                    </a>
                                    <form action="turma-acoes.php" method="POST" class="d-inline">
                                        <button type="submit" name="delete_turma" value="<?= htmlspecialchars($turma['id_turma']); ?>" class="btn btn-danger btn-sm">
                                            <span class="bi-trash3-fill"></span>&nbsp;Excluir
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                                }
                            } else {
                                echo '<tr><td colspan="7" class="text-center">Nenhuma turma encontrada</td></tr>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
