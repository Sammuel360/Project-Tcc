<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Fiscal Cidadão</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <style>
        /* Reset básico */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Roboto', sans-serif;
        }

        /* Layout Principal */
        body {
            display: flex;
            min-height: 100vh;
            background-color: #f9f9f9;
            color: #333;
        }

        /* Barra Superior */
        header .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            background-color: #2563eb;
            color: white;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        header .top-bar h1 {
            font-size: 1.8rem;
            font-weight: bold;
        }

        header .top-bar nav a {
            color: white;
            text-decoration: none;
            margin: 0 1.5rem;
            font-size: 1rem;
            transition: color 0.3s ease;
        }

        header .top-bar nav a:hover {
            color: #f1f1f1;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background-color: #1e293b;
            padding: 2rem 1rem;
            color: white;
            position: fixed;
            top: 0;
            left: -270px;
            height: 100%;
            transition: all 0.3s ease;
        }

        .sidebar.active {
            left: 0;
        }

        .sidebar ul {
            list-style-type: none;
            padding-left: 0;
        }

        .sidebar ul li {
            margin: 1rem 0;
        }

        .sidebar ul li a {
            color: #ccc;
            text-decoration: none;
            font-size: 1.1rem;
            display: flex;
            align-items: center;
            transition: color 0.3s ease;
        }

        .sidebar ul li a:hover {
            color: #fff;
        }

        .sidebar ul li a i {
            margin-right: 1rem;
        }

        #toggle-dark-mode {
            margin-top: 2rem;
            padding: 0.5rem;
            background-color: #2563eb;
            border: none;
            color: white;
            cursor: pointer;
            width: 100%;
        }

        #toggle-dark-mode:hover {
            background-color: #1e40af;
        }

        /* Conteúdo Principal */
        .main-content {
            flex-grow: 1;
            margin-left: 0;
            padding: 3rem;
            transition: margin-left 0.3s ease;
            margin-top: 80px;
        }

        /* Cards */
        .cards-section {
            display: flex;
            gap: 2rem;
            margin-bottom: 2rem;
        }

        .card {
            flex: 1;
            padding: 1.5rem;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            transition: all 0.3s ease;
        }

        .card:hover {
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
        }

        .card h2 {
            font-size: 1.3rem;
            color: #2563eb;
        }

        .card p {
            font-size: 2rem;
            font-weight: bold;
            margin-top: 0.5rem;
        }

        /* Fórum / Comunidade */
        .forum-section {
            background-color: #fff;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            display: flex;
            gap: 2rem;
        }

        .forum-topics,
        .ranking-usuarios {
            flex: 1;
        }

        .forum-topics h3,
        .ranking-usuarios h3 {
            font-size: 1.3rem;
            color: #2563eb;
            margin-bottom: 1rem;
        }

        .topic {
            background-color: #f9f9f9;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1rem;
            transition: all 0.3s ease;
        }

        .topic:hover {
            background-color: #e9e9e9;
        }

        .topic h4 {
            font-size: 1.1rem;
            color: #333;
        }

        .topic p {
            color: #666;
            font-size: 0.95rem;
            margin-top: 0.5rem;
        }

        .topic button {
            margin-top: 0.5rem;
            padding: 0.5rem 1rem;
            background-color: #2563eb;
            border: none;
            color: white;
            cursor: pointer;
            border-radius: 4px;
        }

        .topic button:hover {
            background-color: #1e40af;
        }

        /* Rodapé */
        footer {
            text-align: center;
            padding: 1rem;
            background-color: #1e293b;
            color: white;
            position: fixed;
            bottom: 0;
            width: 100%;
        }

        footer .footer-links a {
            color: #ccc;
            text-decoration: none;
            margin: 0 0.5rem;
        }

        footer .footer-links a:hover {
            color: white;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: -270px;
            }

            .sidebar.active {
                left: 0;
            }

            .main-content {
                margin-left: 0;
            }

            #menu-toggle {
                display: block;
            }

            .menu-button-container {
                display: flex;
                justify-content: flex-start;
            }
        }
    </style>
</head>

<body>
    <!-- Barra de Navegação Superior -->
    <header>
        <div class="top-bar">
            <div class="menu-button-container">
                <div id="menu-toggle" class="fas fa-bars"></div>
            </div>
            <h1>Fiscal Cidadão</h1>
            <nav>
                <a href="dashboard.php">🏠 Início</a>
                <a href="detalhesChamado.php">📊 Status</a>
                <a href="notificacoes.php">🔔 Notificações</a>
                <a href="chamados.php">📝 Chamados</a>
                <a href="configuracoes.php">⚙️ Configurações</a>
                <a href="ajuda.php">❓ Ajuda</a>
                <a href="perfil.php">👤 Perfil</a>

            </nav>
        </div>
    </header>
    <!-- Carousel -->
    <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
        <ol class="carousel-indicators">
            <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="1"></li>
            <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
        </ol>
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img class="d-block w-100"
                    src="https://png.pngtree.com/thumb_back/fw800/background/20230527/pngtree-bus-and-trolleys-in-an-old-looking-city-image_2700896.jpg"
                    alt="Primeiro Slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-100"
                    src="https://th.bing.com/th/id/OIP.fy17NZ1y38UEoAgNlurS-QHaEK?rs=1&pid=ImgDetMain"
                    alt="Segundo Slide">
            </div>
            <div class="carousel-item">
                <img class="d-block w-200"
                    src="https://th.bing.com/th/id/R.b1addf5ccb47805e2e062074207b87fc?rik=8dtl%2begeedt7hQ&pid=ImgRaw&r=0"
                    alt="Terceiro Slide">
            </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="sr-only">Anterior</span>
        </a>
        <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="sr-only">Próximo</span>
        </a>
    </div>

    <!-- Sidebar -->
    <aside class="sidebar">
        <ul>
            <li><a href="#"><i class="fas fa-tachometer-alt"></i> Dashboard</a></li>
            <li><a href="chamados.php"><i class="fas fa-pencil-alt"></i> Abrir Chamado</a></li>
            <li><a href="#"><i class="fas fa-users"></i> Usuários</a></li>
            <li><a href="configuracoes.php"><i class="fas fa-cogs"></i> Configurações</a></li>
            <li><a href="ajuda.php"><i class="fas fa-question-circle"></i> Ajuda</a></li>
        </ul>
        <button id="toggle-dark-mode">Modo Escuro</button>
    </aside>

    <!-- Conteúdo Principal -->
    <main class="main-content">

        </div>

        <div class="forum-section">
            <div class="forum-topics">
                <h3>Últimos Tópicos</h3>
                <div class="topic">
                    <h4>Problema de Iluminação</h4>
                    <p>Descrição do problema que precisa de ajuda...</p>
                    <button>Responder</button>
                </div>
                <div class="topic">
                    <h4>Buracos na Rua</h4>
                    <p>Descrição do problema que precisa de ajuda...</p>
                    <button>Responder</button>
                </div>
            </div>

            <div class="ranking-usuarios">
                <h3>Ranking de Usuários</h3>
                <ul>
                    <li>1. João Silva</li>
                    <li>2. Maria Oliveira</li>
                    <li>3. Carlos Souza</li>
                </ul>
            </div>
        </div>
    </main>

    <!-- Rodapé -->
    <footer>
        <p>&copy; 2024 Fiscal Cidadão - Todos os direitos reservados.</p>
        <div class="footer-links">
            <a href="#">Política de Privacidade</a>
            <a href="#">Termos de Uso</a>
        </div>
    </footer>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Script para alternar o menu lateral
        $("#menu-toggle").click(function() {
            $(".sidebar").toggleClass("active");
        });

        // Script para alternar o modo escuro
        $("#toggle-dark-mode").click(function() {
            $("body").toggleClass("dark-mode");
        });
    </script>
</body>

</html>