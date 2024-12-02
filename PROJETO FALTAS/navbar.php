<?php
// Definir o diretório base, você pode definir isso no topo do seu arquivo PHP
$base_url = '/PROJETO%20FALTAS';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        /* Reset e ajustes gerais */
        * {
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, Helvetica, sans-serif;
        }

        /* Configuração do cabeçalho */
        .logo {
            font-size: 24px;
            text-transform: uppercase;
            letter-spacing: 4px;
            color: white;
        }

        nav {
            display: flex;
            justify-content: space-around;
            align-items: center;
            font-family: system-ui, -apple-system, Helvetica, Arial, sans-serif;
            background: #23232e;
            height: 8vh;
        }

        .nav-list {
            list-style: none;
            display: flex;
        }

        .nav-list li {
            letter-spacing: 3px;
            margin-left: 32px;
        }

        .nav-list a {
            color: #fff;
            text-decoration: none;
            transition: 0.3s;
            position: relative;
        }

        .nav-list a::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background-color: transparent;
            transition: background-color 0.3s ease;
        }

        .nav-list a:hover {
            opacity: 0.7;
            color: #66ccff; /* Azul claro ao passar o mouse */
        }

        .nav-list a:hover::after {
            background-color: #66ccff; /* Brilho azul claro na parte inferior */
        }
    </style>
    <title>Navbar</title>
</head>
<body>
    <header>
        <nav>
            <a class="logo" href="<?= $base_url ?>/login/index.php">Registro de Faltas</a>
            <ul class="nav-list">
                <li><a href="<?= $base_url ?>/login/logout.php">Sair</a></li>
                <li><a href="<?= $base_url ?>/aluno/aluno.php">Alunos</a></li>
                <li><a href="<?= $base_url ?>/funcionario/funcionario.php">Funcionários</a></li>
                <li><a href="<?= $base_url ?>/turma/turma.php">Turmas</a></li>
                <li><a href="<?= $base_url ?>/ocorrencia_aluno/ocorrencia.php">Ocorrências Alunos</a></li>
                <li><a href="<?= $base_url ?>/ocorrencia_funcionario/ocorrenciaf.php">Ocorrências Funcionários</a></li>
                <li><a href="<?= $base_url ?>/relatorio/relatorio.php">Relatórios</a></li>
                <li><a href="<?= $base_url ?>/registro/registros.php">Registros</a></li>
            </ul>
        </nav>
    </header>
</body>
</html>
