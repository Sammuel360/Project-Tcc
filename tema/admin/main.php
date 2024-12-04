// tema/admin/main.php
<?php
// Iniciar a sessão para verificar se o usuário está logado
session_start();

// Verificar se o usuário está logado
if (!isset($_SESSION['usuario'])) {
    header('Location: /cidadaofisca/index.php?c=usuario&a=logar');  // Redireciona para a página de login
    exit();
}

// Incluir o menu lateral
include_once 'includes/menulateral.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Fiscal Cidadão</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
        integrity="sha384-k6RqeWeci5ZR/Lv4MR0sA0FfDOM7PylkiF5jcswrT+YEoix1lL5fN5KVVlfp0i8b" crossorigin="anonymous">
    <link rel="stylesheet" href="includes/menulateral.css">
    <link rel="stylesheet" href="includes/dashboard.css"> <!-- Estilo do Dashboard -->
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