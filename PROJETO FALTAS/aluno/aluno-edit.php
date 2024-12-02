<?php
session_start();
require 'conexao.php'; // Conexão utilizando PDO
?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Editar Aluno</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  </head>
  <body>
    <?php include('../navbar.php'); ?>
   <div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>Editar Aluno
                        <a href="aluno.php" class="btn btn-danger float-end">Voltar</a>
                    </h4>
                </div>
                <div class="card-body">
                <?php
                 if (isset($_GET['id'])) {
                    // Usando PDO para escapar a variável
                    $aluno_id = $_GET['id'];
                    
                    // Consulta usando o nome correto da coluna 'id_aluno'
                    $sql = "SELECT * FROM aluno WHERE id_aluno = :id";  
                    $stmt = $conexao->prepare($sql);
                    $stmt->bindParam(':id', $aluno_id, PDO::PARAM_INT);
                    $stmt->execute();
                    
                    if ($stmt->rowCount() > 0) {
                        $aluno = $stmt->fetch(PDO::FETCH_ASSOC);

                        // Carregar turmas para o select
                        $sql_turmas = 'SELECT * FROM turma';  // Assumindo que a tabela 'turma' existe
                        $stmt_turmas = $conexao->prepare($sql_turmas);
                        $stmt_turmas->execute();
                        $turmas = $stmt_turmas->fetchAll(PDO::FETCH_ASSOC);
                  ?>
                <!-- Formulário de edição com os dados do aluno -->
                <form action="aluno-acoes.php" method="POST">
                    <input type="hidden" name="aluno_id" value="<?= htmlspecialchars($aluno['id_aluno']); ?>">
                  <div class="mb-3">
                    <label>Nome</label>
                    <input type="text" name="nome" value="<?= htmlspecialchars($aluno['nome']); ?>" class="form-control">
                  </div>
                  <div class="mb-3">
                    <label>Matricula</label>
                    <input type="text" name="matricula" value="<?= htmlspecialchars($aluno['matricula']); ?>" class="form-control">
                  </div>
                  <div class="mb-3">
                    <label>Data de Nascimento</label>
                    <input type="date" name="data_nascimento" value="<?= htmlspecialchars($aluno['data_nascimento']); ?>" class="form-control">
                  </div>
                  <div class="mb-3">
                    <label>Telefone</label>
                    <input type="text" name="telefone" value="<?= htmlspecialchars($aluno['telefone']); ?>" class="form-control">
                  </div>
                  <div class="mb-3">
                    <label>ID da Turma</label>
                    <select name="id_turma" class="form-control" required>
                        <?php
                        foreach ($turmas as $turma) {
                            $selected = ($turma['id_turma'] == $aluno['id_turma']) ? 'selected' : ''; 
                            // Exibindo ID da turma no dropdown
                            echo '<option value="' . $turma['id_turma'] . '" ' . $selected . '>' . $turma['id_turma'] . '</option>';
                        }
                        ?>
                    </select>
                  </div>
                  <div class="mb-3">
                    <button type="submit" name="update_aluno" class="btn btn-primary">Salvar</button>
                  </div>
                </form>
                <?php
                } else {
                  echo "<h5>Usuário não encontrado</h5>";
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
