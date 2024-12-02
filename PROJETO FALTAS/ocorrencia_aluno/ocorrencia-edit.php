<?php
session_start();
require 'conexao.php'; // Conexão utilizando PDO
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Ocorrência</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <?php include('../navbar.php'); ?>
    <div class="container mt-5">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h4>Editar Ocorrência
                <a href="ocorrencia.php" class="btn btn-danger float-end">Voltar</a>
              </h4>
            </div>
            <div class="card-body">
              <?php
              if (isset($_GET['id'])) {
                $ocorrencia_id = $_GET['id'];
                
                // Consulta para buscar a ocorrência
                $sql = "SELECT * FROM ocorrencia WHERE id_ocorrencia = :id";
                $stmt = $conexao->prepare($sql);
                $stmt->bindParam(':id', $ocorrencia_id, PDO::PARAM_INT);
                $stmt->execute();
                
                if ($stmt->rowCount() > 0) {
                  $ocorrencia = $stmt->fetch(PDO::FETCH_ASSOC);

                  // Carregar alunos para o select
                  $sql_alunos = 'SELECT * FROM aluno';
                  $stmt_alunos = $conexao->prepare($sql_alunos);
                  $stmt_alunos->execute();
                  $alunos = $stmt_alunos->fetchAll(PDO::FETCH_ASSOC);
                  ?>
                  <!-- Formulário de edição -->
                  <form action="ocorrencia-acoes.php" method="POST">
                    <input type="hidden" name="id_ocorrencia" value="<?= htmlspecialchars($ocorrencia['id_ocorrencia']); ?>">

                    <div class="mb-3">
                      <label>Tipo de Ocorrência</label>
                      <select name="tipo_ocorrencia" class="form-control" required>
                        <option value="Falta" <?= ($ocorrencia['tipo_ocorrencia'] == 'Falta') ? 'selected' : ''; ?>>Falta</option>
                        <option value="Atraso" <?= ($ocorrencia['tipo_ocorrencia'] == 'Atraso') ? 'selected' : ''; ?>>Atraso</option>
                        <option value="Justificativa" <?= ($ocorrencia['tipo_ocorrencia'] == 'Justificativa') ? 'selected' : ''; ?>>Justificativa</option>
                      </select>
                    </div>

                    <div class="mb-3">
                      <label>Aluno</label>
                      <select name="id_aluno" class="form-control" required>
                        <option value="">Selecione o aluno</option>
                        <?php
                        foreach ($alunos as $aluno) {
                          $selected = ($aluno['id_aluno'] == $ocorrencia['id_aluno']) ? 'selected' : '';
                          echo '<option value="' . $aluno['id_aluno'] . '" ' . $selected . '>' . $aluno['nome'] . '</option>';
                        }
                        ?>
                      </select>
                    </div>

                    <div class="mb-3">
                      <label>Data</label>
                      <input type="date" name="data_oco" value="<?= htmlspecialchars($ocorrencia['data_oco']); ?>" class="form-control" required>
                    </div>

                    <div class="mb-3">
                      <label>Descrição</label>
                      <input type="text" name="descricao" value="<?= htmlspecialchars($ocorrencia['descricao']); ?>" class="form-control" required>
                    </div>

                    <div class="mb-3">
                      <label>Justificativa</label>
                      <input type="text" name="justificativa" value="<?= htmlspecialchars($ocorrencia['justificativa']); ?>" class="form-control" required>
                    </div>

                    <div class="mb-3">
                      <button type="submit" name="update_ocorrencia" class="btn btn-primary">Salvar</button>
                    </div>
                  </form>
                  <?php
                } else {
                  echo "<h5>Ocorrência não encontrada</h5>";
                }
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  </body>
</html>
