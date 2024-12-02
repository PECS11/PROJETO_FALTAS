<?php
// Definir as configurações de conexão com o banco de dados
$host = 'localhost'; // Host do banco de dados
$dbname = 'projeto_faltas'; // Nome do banco de dados
$username = 'root'; // Usuário do banco de dados
$password = ''; // Senha do banco de dados (deixe vazio se não houver senha no ambiente de desenvolvimento)

try {
    // Conectar ao banco de dados utilizando PDO
    $conexao = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Definir o modo de erro do PDO
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Caso a conexão seja bem-sucedida
    echo "Conectado ao banco de dados com sucesso!";
} catch (PDOException $e) {
    // Caso haja erro na conexão
    echo "Erro de conexão: " . $e->getMessage();
}
?>
