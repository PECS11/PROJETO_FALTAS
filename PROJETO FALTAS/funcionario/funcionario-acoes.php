<?php
session_start();
require 'conexao.php'; // Conexão utilizando PDO

if (isset($_POST['create_funcionario'])) {
    // Prepara os dados recebidos via POST
    $nome = trim($_POST['nome']);
    $cargo = trim($_POST['cargo']);
    $data_nascimento = trim($_POST['data_nascimento']);
    $telefone = trim($_POST['telefone']);
    $setor = trim($_POST['setor']);

    // Validação dos campos obrigatórios
    if (empty($nome) || empty($cargo) || empty($data_nascimento) || empty($telefone) || empty($setor)) {
        $_SESSION['mensagem'] = "Todos os campos são obrigatórios. Por favor, preencha todos os dados.";
        header('Location: funcionario.php');
        exit;
    }

    // Prepara a query com placeholders para evitar SQL Injection
    $sql = "INSERT INTO funcionario (nome, cargo, data_nascimento, telefone, setor) 
            VALUES (:nome, :cargo, :data_nascimento, :telefone, :setor)";
    
    try {
        // Prepara o statement
        $stmt = $conexao->prepare($sql);

        // Executa a query com os parâmetros
        $stmt->execute([
            ':nome' => $nome,
            ':cargo' => $cargo,
            ':data_nascimento' => $data_nascimento,
            ':telefone' => $telefone,
            ':setor' => $setor,
        ]);

        // Verifica se a inserção afetou alguma linha
        if ($stmt->rowCount() > 0) {
            $_SESSION['mensagem'] = "Funcionario criado com sucesso";
        } else {
            $_SESSION['mensagem'] = "Funcionario não foi criado";
        }

        // Redireciona para a página inicial
        header('Location: funcionario.php');
        exit;
    } catch (PDOException $e) {
        // Captura erros e define uma mensagem
        $_SESSION['mensagem'] = "Erro ao inserir Funcionario: " . $e->getMessage();
        header('Location: funcionario.php');
        exit;
    }
}

if (isset($_POST['update_funcionario'])) {

    // Captura dos dados do formulário
    $funcionario_id = $_POST['funcionario_id'];
    $nome = trim($_POST['nome']);
    $cargo = trim($_POST['cargo']);
    $data_nascimento = trim($_POST['data_nascimento']);
    $telefone = trim($_POST['telefone']);
    $setor = trim($_POST['setor']);
    
    // Prepara a consulta de atualização com parâmetros nomeados
    $sql = "UPDATE funcionario SET nome = :nome, cargo = :cargo, data_nascimento = :data_nascimento, telefone = :telefone, setor = :setor WHERE id_funcionario = :funcionario_id";
    
    // Preparando a consulta
    $stmt = $conexao->prepare($sql);
    
    // Vinculando os parâmetros
    $stmt->bindParam(':nome', $nome, PDO::PARAM_STR);
    $stmt->bindParam(':cargo', $cargo, PDO::PARAM_STR);
    $stmt->bindParam(':data_nascimento', $data_nascimento, PDO::PARAM_STR);
    $stmt->bindParam(':telefone', $telefone, PDO::PARAM_STR);
    $stmt->bindParam(':setor', $setor, PDO::PARAM_STR);
    $stmt->bindParam(':funcionario_id', $funcionario_id, PDO::PARAM_INT);
    
    // Executando a consulta
    if ($stmt->execute()) {
        $_SESSION['mensagem'] = 'Funcionario atualizado com sucesso';
    } else {
        $_SESSION['mensagem'] = 'Funcionario não foi atualizado';
    }
    
    // Redirecionando de volta
    header('Location: funcionario.php');
    exit;
}


if (isset($_POST['delete_funcionario'])) {

    // Captura o id do aluno a ser deletado
    $funcionario_id = $_POST['delete_funcionario'];

    // Prepara a consulta de deleção
    $sql = "DELETE FROM funcionario WHERE id_funcionario = :funcionario_id";

    // Preparando a consulta
    $stmt = $conexao->prepare($sql);

    // Vinculando o parâmetro
    $stmt->bindParam(':funcionario_id', $funcionario_id, PDO::PARAM_INT);

    // Executando a consulta
    if ($stmt->execute()) {
        $_SESSION['message'] = 'Funcionario deletado com sucesso';
    } else {
        $_SESSION['message'] = 'Funcionario não foi deletado';
    }

    // Redirecionando de volta
    header('Location: funcionario.php');
    exit;
}
?>

?>
