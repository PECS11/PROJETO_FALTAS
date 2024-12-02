<?php
session_start();
require 'conexao.php'; // Conexão utilizando PDO
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Registro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <?php include('../navbar.php'); ?>
   <div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Editar Registro
                        <a href="registros.php" class="btn btn-danger float-end">Voltar</a>
                    </h4>
                </div>
                <div class="card-body">
                <?php
                 if (isset($_GET['id'])) {
                    // Usando PDO para escapar a variável
                    $registro_id = $_GET['id'];
                    
                    // Consulta usando o nome correto da coluna 'id_registro'
                    $sql = "SELECT * FROM registro WHERE id_registro = :id";  
                    $stmt = $conexao->prepare($sql);
                    $stmt->bindParam(':id', $registro_id, PDO::PARAM_INT);
                    $stmt->execute();
                    
                    if ($stmt->rowCount() > 0) {
                        $registro = $stmt->fetch(PDO::FETCH_ASSOC);
                  ?>
                <!-- Formulário de edição com os dados do registro -->
                <form action="registro-acoes.php" method="POST">
                    <input type="hidden" name = "registro_id" value="<?= htmlspecialchars($registro['id_registro']); ?>">
                  <div class="mb-3">
                    <label>Nome</label>
                    <input type="text" name="nome" value="<?= htmlspecialchars($registro['nome']); ?>" class="form-control">
                  </div>
                  <div class="mb-3">
                    <label>Sobrenome</label>
                    <input type="text" name="sobrenome" value="<?= htmlspecialchars($registro['sobrenome']); ?>" class="form-control">
                  </div>
                  <div class="mb-3">
                    <label>Email</label>
                    <input type="text" name="email" value="<?= htmlspecialchars($registro['email']); ?>" class="form-control">
                  </div>
                  <div class="mb-3">
                    <label>Senha</label>
                    <input type="text" name="senha" value="<?= htmlspecialchars($registro['senha']); ?>" class="form-control">
                  </div>
                  <div class="mb-3">
                    <button type="submit" name="update_registro" class="btn btn-primary">Salvar</button>
                  </div>
                </form>
                <?php
                } else {
                  echo "<h5>Registro não encontrado</h5>";
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
