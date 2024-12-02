<?php
require 'conexao.php';
session_start(); // Inicia a sessão
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Lista de Alunos</title>
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
                        <h4> Lista de Alunos 
                        <a href="aluno-create.php" class="btn btn-primary float-end">Adicionar Aluno</a>
                        </h4>
                    </div>
                </div>
                <div class="card-body">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>Nome</th>
                                <th>Matricula</th>
                                <th>Data Nascimento</th>
                                <th>Telefone</th>
                                <th>Turma</th>
                                <th>Ações</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Buscar alunos
                            $sql = 'SELECT aluno.*, turma.nome AS nome_turma
                                    FROM aluno
                                    LEFT JOIN turma ON aluno.id_turma = turma.id_turma'; // Junta a tabela 'turma' para obter o nome
                            $stmt = $conexao->prepare($sql);
                            $stmt->execute();
                            $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                            if (count($alunos) > 0) {
                                foreach ($alunos as $aluno) {
                            ?>
                            <tr>
                                <td><?= $aluno['id_aluno']; ?></td>
                                <td><?= $aluno['nome']; ?></td>
                                <td><?= $aluno['matricula']; ?></td>
                                <td><?= date('d/m/y', strtotime($aluno['data_nascimento'])); ?></td>
                                <td><?= $aluno['telefone']; ?></td>
                                <td><?= $aluno['nome_turma'] ? $aluno['nome_turma'] : 'Sem turma'; ?></td> <!-- Exibe o nome da turma -->
                                <td>
                                    <a href="aluno-view.php?id=<?=$aluno['id_aluno']?>" class="btn btn-secondary btn-sm"><span class="bi-eye-fill"></span>&nbsp;Visualizar</a>
                                    <a href="aluno-edit.php?id=<?=$aluno['id_aluno']?>" class="btn btn-success btn-sm"><span class="bi-pencil-fill"></span>&nbsp;Editar</a>
                                    <form action="aluno-acoes.php" method="POST" class="d-inline">
                                        <button type="submit" name="delete_aluno" value="<?=$aluno['id_aluno']?>" class="btn btn-danger btn-sm"> <span class="bi-trash3-fill"></span>&nbsp;
                                            Excluir
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            <?php
                                }
                            } else {
                                echo '<h5> Nenhum aluno encontrado</h5>';
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
