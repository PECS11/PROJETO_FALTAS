<?php
session_start();
require 'conexao.php'; // Conexão utilizando PDO
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrar Ocorrência</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <?php include('../navbar.php'); ?>
    <div class="container mt-5">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h4>Adicionar Ocorrência
                <a href="ocorrencia.php" class="btn btn-danger float-end">Voltar</a>
              </h4>
            </div>
            <div class="card-body">
              <!-- Mostrar mensagens de erro -->
              <?php
              if (isset($_SESSION['mensagem'])) {
                  echo '<div class="alert alert-danger">' . $_SESSION['mensagem'] . '</div>';
                  unset($_SESSION['mensagem']);
              }
              ?>

              <form action="ocorrencia-acoes.php" method="POST">
              <div class="mb-3">
        <label>Tipo de Ocorrência</label>
        <select name="tipo_ocorrencia" class="form-control" required>
            <option value="">Selecione o tipo de ocorrência</option>
            <option value="Falta">Falta</option>
            <option value="Falta">Atraso</option>
            <option value="Falta">Justificativa</option>
        </select>
    </div>

                <div class="mb-3">
                  <label>Aluno</label>
                  <select name="id_aluno" class="form-control" required>
                    <option value="">Selecione o aluno</option>
                    <?php
                    // Consulta para buscar todos os alunos
                    $sql = 'SELECT * FROM aluno';
                    $stmt = $conexao->prepare($sql);
                    $stmt->execute();
                    $alunos = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Exibir os alunos no select
                    foreach ($alunos as $aluno) {
                        echo '<option value="' . $aluno['id_aluno'] . '">' . $aluno['nome'] . '</option>';
                    }
                    ?>
                  </select>
                </div>

                <div class="mb-3">
                  <label>Data</label>
                  <input type="date" name="data_oco" class="form-control" required>
                </div>

                <div class="mb-3">
                  <label>Descrição</label>
                  <input type="text" name="descricao" class="form-control" required>
                </div>

                <div class="mb-3">
                  <label>Justificativa</label>
                  <input type="text" name="justificativa" class="form-control" required>
                </div>

                <div class="mb-3">
                  <button type="submit" name="create_ocorrencia" class="btn btn-primary">Salvar</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
