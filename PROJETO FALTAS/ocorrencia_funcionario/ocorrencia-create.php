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
                <a href="ocorrenciaf.php" class="btn btn-danger float-end">Voltar</a>
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
                      <option value="Atraso">Atraso</option>
                      <option value="Justificativa">Justificativa</option>
                  </select>
                </div>

                <div class="mb-3">
                  <label>Funcionário</label>
                  <select name="id_funcionario" class="form-control" required>
                    <option value="">Selecione o funcionário</option>
                    <?php
                    // Consulta para buscar todos os funcionários
                    $sql = 'SELECT * FROM funcionario';
                    $stmt = $conexao->prepare($sql);
                    $stmt->execute();
                    $funcionarios = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    // Exibir os funcionários no select
                    foreach ($funcionarios as $funcionario) {
                        echo '<option value="' . $funcionario['id_funcionario'] . '">' . $funcionario['nome'] . '</option>';
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
