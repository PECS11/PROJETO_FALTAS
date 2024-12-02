<?php
require 'conexao.php';
session_start(); // Inicia a sessão
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrar Funcionario</title>
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
                    <h4>Lista de Funcionários 
                        <a href="funcionario-create.php" class="btn btn-primary float-end">Adicionar Funcionário</a>
                    </h4>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nome</th>
                                <th>Cargo</th>
                                <th>Data Nascimento</th>
                                <th>Telefone</th>
                                <th>Setor</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $sql = 'SELECT * FROM funcionario';
                            $stmt = $conexao->prepare($sql);
                            $stmt->execute();
                            $funcionarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            if (count($funcionarios) > 0) {
                                foreach ($funcionarios as $funcionario) {
                            ?>
                            <tr>
                                <td><?= htmlspecialchars($funcionario['id_funcionario']); ?></td>
                                <td><?= htmlspecialchars($funcionario['nome']); ?></td>
                                <td><?= htmlspecialchars($funcionario['cargo']); ?></td>
                                <td><?= date('d/m/Y', strtotime($funcionario['data_nascimento'])); ?></td>
                                <td><?= htmlspecialchars($funcionario['telefone']); ?></td>
                                <td><?= htmlspecialchars($funcionario['setor']); ?></td>
                                <td>
                                    <a href="funcionario-view.php?id=<?= htmlspecialchars($funcionario['id_funcionario']); ?>" class="btn btn-secondary btn-sm">
                                        <span class="bi-eye-fill"></span>&nbsp;Visualizar
                                    </a>
                                    <a href="funcionario-edit.php?id=<?= htmlspecialchars($funcionario['id_funcionario']); ?>" class="btn btn-success btn-sm">
                                        <span class="bi-pencil-square"></span>&nbsp;Editar
                                    </a>
                                    <form action="funcionario-acoes.php" method="POST" class="d-inline">
                                        <button type="submit" name="delete_funcionario" value="<?= htmlspecialchars($funcionario['id_funcionario']); ?>" class="btn btn-danger btn-sm">
                                            <span class="bi-trash3-fill"></span>&nbsp;Excluir
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                                }
                            } else {
                                echo '<tr><td colspan="7" class="text-center">Nenhum funcionário encontrado</td></tr>';
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
