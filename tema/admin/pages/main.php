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
include_once __DIR__ . '/../includes/menulateral.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Fiscal Cidadão</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">
    <!-- Para ícones -->
    <style>
    body {
        background-color: #f4f4f9;
        font-family: Arial, sans-serif;
    }

    .dashboard-header {
        text-align: center;
        margin-top: 20px;
    }

    .dashboard-header h1 {
        font-size: 2.5rem;
        color: #333;
    }

    .dashboard-header p {
        font-size: 1.1rem;
        color: #777;
    }

    .dashboard {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 20px;
        margin-top: 40px;
    }

    .card {
        background-color: #fff;
        border: 1px solid #ddd;
        border-radius: 10px;
        padding: 20px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        text-align: center;
    }

    .card h3 {
        font-size: 1.6rem;
        color: #333;
    }

    .card p {
        font-size: 1.2rem;
        color: #777;
    }

    .card .icon {
        font-size: 3rem;
        color: #3498db;
        margin-bottom: 15px;
    }

    .chart-container {
        margin-top: 20px;
    }

    .dashboard-links ul {
        list-style: none;
        padding: 0;
        margin-top: 40px;
    }

    .dashboard-links ul li {
        padding: 10px 0;
        text-align: center;
    }

    .dashboard-links ul li a {
        text-decoration: none;
        color: #3498db;
        font-size: 1.2rem;
        transition: color 0.3s ease;
    }

    .dashboard-links ul li a:hover {
        color: #2980b9;
    }
    </style>
</head>

<body>
    <div id="carouselExample" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="https://www.osguedes.com.br/wp-content/uploads/2023/09/Castramovel.jpg" class="d-block w-100"
                    alt="Imagem 1">
            </div>
            <div class="carousel-item">
                <img src="image2.jpg" class="d-block w-100" alt="Imagem 2">
            </div>
            <div class="carousel-item">
                <img src="image3.jpg" class="d-block w-100" alt="Imagem 3">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExample" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Anterior</span>
        </a>
        <a class="carousel-control-next" href="#carouselExample" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Próximo</span>
        </a>
    </div>


    <div class="container-fluid">
        <!-- Header com título e descrição -->
        <div class="dashboard-header">
            <h1>Configurações - Fiscal Cidadão</h1>
            <p>Atualize suas informações pessoais e de contato</p>
        </div>

        <!-- Dashboard com os cards -->
        <div class="dashboard">
            <div class="card">
                <div class="icon"><i class="fas fa-ticket-alt"></i></div>
                <h3>Chamados</h3>
                <p>232 Chamados</p>
            </div>
            <div class="card">
                <div class="icon"><i class="fas fa-exclamation-triangle"></i></div>
                <h3>Chamados Atrasados</h3>
                <p>58 Chamados atrasados</p>
            </div>

            <div class="card">
                <div class="icon"><i class="fas fa-exchange-alt"></i></div>
                <h3>Mudanças</h3>
                <p>6 Mudanças</p>
            </div>
            <div class="card">
                <div class="icon"><i class="fas fa-plus-square"></i></div>
                <h3>Chamados Novos</h3>
                <p>53 Chamados novos</p>
            </div>
            <div class="card">
                <div class="icon"><i class="fas fa-user-tag"></i></div>
                <h3>Chamados Atribuídos</h3>
                <p>139 Chamados atribuídos</p>
            </div>
            <div class="card">
                <div class="icon"><i class="fas fa-check-square"></i></div>
                <h3>Chamados Fechados</h3>
                <p>187 Chamados fechados</p>
            </div>
            <div class="card">
                <h3>Estatísticas</h3>
                <div class="icon"><i class="fas fa-chart-bar"></i></div>
                <div class="chart-container">
                    <canvas id="chart"></canvas>
                </div>
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

    <!-- Script para gráfico -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
    // Inicializa o gráfico usando Chart.js
    var ctx = document.getElementById('chart').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: '# de Chamados',
                data: [12, 19, 3, 5, 2, 3, 4, 2, 3, 5, 6, 2],
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
    </script>

</body>

</html>