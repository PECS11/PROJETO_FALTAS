<?php
session_start();
require 'conexao.php'; // Conexão utilizando PDO

// Verificar se um ID foi passado para exclusão
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $entidade = $_GET['entidade']; // 'funcionario' ou 'aluno'
    $tabela = $entidade === 'funcionario' ? 'funcionario' : 'aluno';
    $id_campo_ocorrencia = $entidade === 'funcionario' ? 'id_funcionario' : 'id_aluno';

    // Deletar ocorrência
    $sql = "DELETE FROM ocorrencia WHERE id_ocorrencia = :delete_id";
    $stmt = $conexao->prepare($sql);
    $stmt->bindParam(':delete_id', $delete_id, PDO::PARAM_INT);
    if ($stmt->execute()) {
        $_SESSION['mensagem'] = 'Ocorrência deletada com sucesso';
    } else {
        $_SESSION['mensagem'] = 'Erro ao deletar ocorrência';
    }
    header('Location: ' . $_SERVER['PHP_SELF'] . '?entidade=' . $entidade);
    exit;
}

?>
<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Relatório de Ocorrências</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>
    <?php include('../navbar.php'); ?>
    <div class="container mt-5">
      <div class="row">
        <div class="col-md-12">
          <div class="card">
            <div class="card-header">
              <h4>Gerar Relatório de Ocorrências
              </h4>
            </div>
            <div class="card-body">
              <form method="GET" action="">
                <div class="mb-3">
                  <label for="entidade" class="form-label">Selecione o Tipo de Ocorrência</label>
                  <select name="entidade" id="entidade" class="form-control" required>
                    <option value="">Selecione</option>
                    <option value="funcionario">Funcionário</option>
                    <option value="aluno">Aluno</option>
                  </select>
                </div>
                <div class="mb-3">
                  <button type="submit" class="btn btn-primary">Gerar Relatório</button>
                </div>
              </form>

              <?php
              if (isset($_GET['entidade'])) {
                  $entidade = $_GET['entidade'];
                  $tabela = $entidade === 'funcionario' ? 'funcionario' : 'aluno';
                  $id_campo_ocorrencia = $entidade === 'funcionario' ? 'id_funcionario' : 'id_aluno';

                  // Consulta para buscar os dados de ocorrências
                  $sql = "
                      SELECT 
                          ocorrencia.id_ocorrencia, 
                          $tabela.id_$entidade AS id,
                          $tabela.nome AS nome,
                          ocorrencia.tipo_ocorrencia, 
                          ocorrencia.data_oco, 
                          ocorrencia.descricao, 
                          ocorrencia.justificativa
                      FROM $tabela
                      LEFT JOIN ocorrencia ON $tabela.id_$entidade = ocorrencia.$id_campo_ocorrencia
                      ORDER BY nome ASC";

                  $stmt = $conexao->prepare($sql);
                  $stmt->execute();
                  $relatorios = $stmt->fetchAll(PDO::FETCH_ASSOC);

                  if (count($relatorios) > 0) {
                      echo "<h5 class='mt-4'>Relatório de Ocorrências ({$entidade})</h5>";
                      echo "<table class='table table-bordered mt-3'>
                              <thead>
                                  <tr>
                                      <th>ID</th>
                                      <th>Nome</th>
                                      <th>Tipo de Ocorrência</th>
                                      <th>Data</th>
                                      <th>Descrição</th>
                                      <th>Justificativa</th>
                                      <th>Ações</th>
                                  </tr>
                              </thead>
                              <tbody>";
                      foreach ($relatorios as $relatorio) {
                          echo "<tr>
                                  <td>{$relatorio['id']}</td>
                                  <td>{$relatorio['nome']}</td>
                                  <td>{$relatorio['tipo_ocorrencia']}</td>
                                  <td>{$relatorio['data_oco']}</td>
                                  <td>{$relatorio['descricao']}</td>
                                  <td>{$relatorio['justificativa']}</td>
                                  <td>
                                    <a href='edit_ocorrencia.php?id={$relatorio['id_ocorrencia']}&entidade={$entidade}' class='btn btn-warning btn-sm'>Editar</a>
                                    <a href='?delete_id={$relatorio['id_ocorrencia']}&entidade={$entidade}' class='btn btn-danger btn-sm' onclick='return confirm(\"Tem certeza que deseja deletar esta ocorrência?\")'>Deletar</a>
                                  </td>
                                </tr>";
                      }
                      echo "</tbody></table>";
                  } else {
                      echo "<div class='alert alert-warning mt-4'>Nenhuma ocorrência encontrada para {$entidade}s.</div>";
                  }
              }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
  </body>
</html>
