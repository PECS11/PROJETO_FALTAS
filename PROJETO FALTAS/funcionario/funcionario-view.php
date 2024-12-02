<?php
session_start();
require 'conexao.php'; // Conexão utilizando PDO
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Funcionario - Visualizar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <?php include('../navbar.php'); ?>
   <div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Visualizar Funcionario
                        <a href="funcionario.php" class="btn btn-danger float-end">Voltar</a>
                    </h4>
                </div>
                <div class="card-body">
                <?php
              if (isset($_GET['id'])) {
                  // Usando PDO para escapar a variável
                  $funcionario_id = $_GET['id'];
                  
                  // Consulta usando o nome correto da coluna 'id_funcionario'
                  $sql = "SELECT * FROM funcionario WHERE id_funcionario = :id";  
                  $stmt = $conexao->prepare($sql);
                  $stmt->bindParam(':id', $funcionario_id, PDO::PARAM_INT);
                  $stmt->execute();
                  
                  if ($stmt->rowCount() > 0) {
                      $funcionario = $stmt->fetch(PDO::FETCH_ASSOC);
                ?>
                <div class="mb-3">
                  <label>Nome</label>
                  <p class="form-control"><?= $funcionario['nome']; ?></p>
                </div>
                <div class="mb-3">
                  <label>Cargo</label>
                  <p class="form-control"><?= $funcionario['cargo']; ?></p>
                </div>
                <div class="mb-3">
                  <label>Data Nascimento</label>
                  <p class="form-control"><?= date('d/m/y', strtotime($funcionario['data_nascimento'])); ?></p>
                </div>
                <div class="mb-3">
                  <label>Telefone</label>
                  <p class="form-control"><?= $funcionario['telefone']; ?></p>
                </div>
                <div class="mb-3">
                  <label>Setor</label>
                  <p class="form-control"><?= $funcionario['setor']; ?></p>
                </div>
                <?php
                } else {
                  echo "<h5>Funcionario não encontrado</h5>";
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
