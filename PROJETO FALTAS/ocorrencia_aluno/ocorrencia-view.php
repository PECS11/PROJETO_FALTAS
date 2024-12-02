<?php
session_start();
require 'conexao.php'; // Conexão utilizando PDO
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Ocorrência - Visualizar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <?php include('../navbar.php'); ?>
   <div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Visualizar Ocorrência
                        <a href="ocorrencia.php" class="btn btn-danger float-end">Voltar</a>
                    </h4>
                </div>
                <div class="card-body">
                <?php
              if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                  $ocorrencia_id = (int)$_GET['id']; // Garantir que o ID seja numérico
                  
                  // Consulta para buscar dados da ocorrência e do aluno
                  $sql = "SELECT ocorrencia.*, aluno.nome AS aluno_nome
                          FROM ocorrencia
                          LEFT JOIN aluno ON ocorrencia.id_aluno = aluno.id_aluno
                          WHERE ocorrencia.id_ocorrencia = :id";
                  $stmt = $conexao->prepare($sql);
                  $stmt->bindParam(':id', $ocorrencia_id, PDO::PARAM_INT);

                  try {
                      $stmt->execute();
                      if ($stmt->rowCount() > 0) {
                          $ocorrencia = $stmt->fetch(PDO::FETCH_ASSOC);
                          ?>
                          <div class="mb-3">
                            <label>Aluno</label>
                            <p class="form-control"><?= htmlspecialchars($ocorrencia['aluno_nome'] ?? 'Não encontrado'); ?></p>
                          </div>
                          <div class="mb-3">
                            <label>Tipo de Ocorrência</label>
                            <p class="form-control"><?= htmlspecialchars($ocorrencia['tipo_ocorrencia']); ?></p>
                          </div>
                          <div class="mb-3">
                            <label>Data</label>
                            <p class="form-control"><?= date('d/m/Y', strtotime($ocorrencia['data_oco'])); ?></p>
                          </div>
                          <div class="mb-3">
                            <label>Descrição</label>
                            <p class="form-control"><?= htmlspecialchars($ocorrencia['descricao']); ?></p>
                          </div>
                          <div class="mb-3">
                            <label>Justificativa</label>
                            <p class="form-control"><?= htmlspecialchars($ocorrencia['justificativa']); ?></p>
                          </div>
                          <?php
                      } else {
                          echo "<h5 class='text-danger'>Ocorrência não encontrada.</h5>";
                      }
                  } catch (PDOException $e) {
                      echo "<h5 class='text-danger'>Erro ao buscar os dados: " . htmlspecialchars($e->getMessage()) . "</h5>";
                  }
              } else {
                  echo "<h5 class='text-danger'>ID inválido fornecido.</h5>";
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
