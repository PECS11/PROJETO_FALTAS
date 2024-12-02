<?php
session_start();
require 'conexao.php'; // Conexão utilizando PDO
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Turma</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <?php include('../navbar.php'); ?>
   <div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Editar Turma
                        <a href="turma.php" class="btn btn-danger float-end">Voltar</a>
                    </h4>
                </div>
                <div class="card-body">
                <?php
                 if (isset($_GET['id'])) {
                    // Usando PDO para escapar a variável
                    $turma_id = $_GET['id'];
                    
                    // Consulta usando o nome correto da coluna 'id_turma'
                    $sql = "SELECT * FROM turma WHERE id_turma = :id";  
                    $stmt = $conexao->prepare($sql);
                    $stmt->bindParam(':id', $turma_id, PDO::PARAM_INT);
                    $stmt->execute();
                    
                    if ($stmt->rowCount() > 0) {
                        $turma = $stmt->fetch(PDO::FETCH_ASSOC);
                  ?>
                <!-- Formulário de edição com os dados da turma -->
                <form action="turma-acoes.php" method="POST">
                    <input type="hidden" name = "turma_id" value="<?= htmlspecialchars($turma['id_turma']); ?>">
                  <div class="mb-3">
                    <label>Nome</label>
                    <input type="text" name="nome" value="<?= htmlspecialchars($turma['nome']); ?>" class="form-control">
                  </div>
                  <div class="mb-3">
                    <label>Curso</label>
                    <input type="text" name="curso" value="<?= htmlspecialchars($turma['curso']); ?>" class="form-control">
                  </div>
                  <div class="mb-3">
                    <label>Turno</label>
                    <input type="text" name="turno" value="<?= htmlspecialchars($turma['turno']); ?>" class="form-control">
                  </div>
                  <div class="mb-3">
                    <button type="submit" name="update_turma" class="btn btn-primary">Salvar</button>
                  </div>
                </form>
                <?php
                } else {
                  echo "<h5>Turma não encontrada</h5>";
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
