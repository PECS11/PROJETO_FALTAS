<?php
session_start();
require 'conexao.php'; // Conexão utilizando PDO
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrar Aluno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <?php include('../navbar.php'); ?>
    <div class="container mt-5">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h4>Adicionar Aluno
                <a href="aluno.php" class="btn btn-danger float-end">Voltar</a>
              </h4>
            </div>
            <div class="card-body">
              <!-- Verificar se houve algum erro ao adicionar o aluno -->
              <?php
              if (isset($_SESSION['error_message'])) {
                  echo '<div class="alert alert-danger">' . $_SESSION['error_message'] . '</div>';
                  unset($_SESSION['error_message']);
              }
              ?>

              <form action="aluno-acoes.php" method="POST">
                <div class="mb-3">
                  <label>Nome</label>
                  <input type="text" name="nome" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label>Matricula</label>
                  <input type="text" name="matricula" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label>Data de Nascimento</label>
                  <input type="date" name="data_nascimento" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label>Telefone</label>
                  <input type="text" name="telefone" class="form-control" required>
                </div>
                <div class="mb-3">
                  <label>Turma</label>
                  <select name="id_turma" class="form-control" required>
                    <option value="">Selecione a turma</option>
                    <?php
                    // Consulta para buscar todas as turmas
                    $sql = 'SELECT * FROM turma'; // Certifique-se de que a tabela "turma" existe no banco
                    $stmt = $conexao->prepare($sql);
                    $stmt->execute();
                    $turmas = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Exibir as turmas disponíveis no select
                    foreach ($turmas as $turma) {
                      echo '<option value="' . $turma['id_turma'] . '">' . $turma['nome'] . '</option>';
                    }
                    ?>
                  </select>
                </div>
                <div class="mb-3">
                  <button type="submit" name="create_aluno" class="btn btn-primary">Salvar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
