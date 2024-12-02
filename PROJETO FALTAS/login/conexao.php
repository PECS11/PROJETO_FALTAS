<?php
define('HOST', 'localhost');
define('USUARIO', 'root');
define('SENHA', '123');
define('DB', 'projeto_faltas');

try {
    $conexao = new PDO("mysql:host=" . HOST . ";dbname=" . DB, USUARIO, SENHA);
    $conexao->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Conexão bem-sucedida!";
} catch (PDOException $e) {
    die("Não foi possível conectar: " . $e->getMessage());
}

?>
