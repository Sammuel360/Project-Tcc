<?php
// Iniciar a sessão para verificar se o usuário está logado
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    header('Location: /cidadaofisca/index.php?c=usuario&a=logar');  // Redireciona para a página de login
    exit();
}

// Incluir o menu lateral
include_once __DIR__ . '/../includes/menulateral.php'

?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Fiscal Cidadão</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="includes/menulateral.css">

</head>

<body>
    <div class="container">
        <div class="content-wrapper" style="margin-left: 260px; padding: 20px;">
            <h1>Bem-vindo à Dashboard</h1>
            <p>Visão geral do sistema Fiscal Cidadão</p>

            <!-- Exemplo de Gráficos ou Cards com informações -->
            <div class="dashboard-cards">
                <div class="card">
                    <h3>Total de Chamados</h3>
                    <p>150</p>
                </div>
                <div class="card">
                    <h3>Chamados Pendentes</h3>
                    <p>20</p>
                </div>
                <div class="card">
                    <h3>Chamados Concluídos</h3>
                    <p>130</p>
                </div>
            </div>

            <!-- Links para páginas do sistema -->
            <div class="dashboard-links">
                <ul>
                    <li><a href="index.php?c=chamado&a=abrirFormulario">Abrir Chamado</a></li>
                    <li><a href="index.php?c=chamado&a=listaChamados">Ver Chamados</a></li>
                    <li><a href="index.php?c=usuario&a=cadastrar">Cadastrar Novo Usuário</a></li>
                    <!-- Outras opções -->
                </ul>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="includes/script.js"></script>
</body>

</html>