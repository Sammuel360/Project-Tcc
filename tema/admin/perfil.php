<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurações - Fiscal Cidadão</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7f9;
            font-family: 'Roboto', sans-serif;
        }

        /* Barra Superior */
        header .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            background-color: #0066cc;
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
        }

        header .top-bar .profile-section {
            display: flex;
            align-items: center;
        }

        header .top-bar .profile-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            margin-right: 0.5rem;
        }

        .dashboard-header {
            margin: 20px 0;
            color: #333;
        }

        #sidebar {
            height: 100%;
            width: 260px;
            position: fixed;
            top: 0;
            left: -260px;
            background-color: #1e293b;
            color: white;
            z-index: 1000;
            padding-top: 20px;
            transition: all 0.3s;
        }

        #sidebar.active {
            left: 0;
        }

        #sidebar .sidebar-header {
            padding: 20px;
            background-color: #2563eb;
            font-size: 1.3rem;
        }

        #sidebar ul {
            list-style: none;
            padding: 0;
        }

        #sidebar ul li a {
            color: white;
            padding: 15px 20px;
            display: block;
            text-decoration: none;
            font-size: 1.1rem;
        }

        #sidebar ul li a:hover {
            background-color: #2563eb;
            border-radius: 5px;
        }

        #content {
            margin-left: 20px;
            padding: 20px;
            transition: margin-left 0.3s;
        }

        #content.shifted {
            margin-left: 270px;
        }

        .card {
            margin-bottom: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .navbar {
            background-color: #2563eb;
            color: white;
        }

        .navbar h2 {
            color: white;
            margin-left: 20px;
        }

        #sidebarCollapse {
            background-color: #2563eb;
            color: white;
            border: none;
            font-size: 1.2rem;
            margin-right: 15px;
        }

        @media (max-width: 768px) {
            #sidebar {
                width: 100%;
                position: relative;
            }

            #content {
                margin-left: 0;
            }

        }

        #sidebarCollapse,
        #sidebarCollapseTop {
            position: fixed;
            /* Fixa o botão na tela */
            top: 20px;
            /* Distância do topo da tela */
            left: 20px;
            /* Distância da borda esquerda (ajuste conforme necessário) */
            z-index: 1050;
            /* Garante que o botão fique acima de outros elementos */
            background-color: #17a2b8;
            /* Cor de fundo, ajuste conforme necessário */
            color: white;
            /* Cor do texto */
            border: none;
            /* Remove bordas */
            padding: 10px 15px;
            /* Tamanho do botão */
            border-radius: 5px;
            /* Arredonda os cantos do botão */
            font-size: 20px;
            /* Tamanho da fonte */
            cursor: pointer;
            /* Aparece como um ponteiro ao passar o mouse */
        }

        #sidebarCollapseTop {
            top: 20px;
            /* Distância do topo da tela, você pode ajustar conforme necessário */
            right: 20px;
            /* Distância da borda direita */
        }
    </style>
</head>

<body>
    <header>
        <div class="top-bar">
            <div class="menu-button-container">
                <div id="menu-toggle">&#9776;</div>
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

    <button id="sidebarCollapse" class="btn btn-info">☰</button>
    <nav id="sidebar">
        <div class="sidebar-header">
            <h3>Fiscal Cidadão</h3>
        </div>
        <ul class="list-unstyled components">
            <li><a href="dashboard.php">🏠 Início</a></li>
            <li><a href="detalhesChamado.php">📊 Status</a></li>
            <li><a href="notificacoes.php">🔔 Notificações</a></li>
            <li><a href="perfil.php">👤 Perfil</a></li>
            <li><a href="configuracoes.php">⚙️ Configurações</a></li>
            <li><a href="ajuda.php">❓ Ajuda</a></li>
            <li><a href="chamados.php">📝 Chamados</a></li>
        </ul>
    </nav>

    <div id="content">
        <div class="container-fluid">
            <div class="dashboard-header text-center">
                <h1>Configurações - Fiscal Cidadão</h1>
                <p>Atualize suas informações pessoais e de contato</p>
            </div>

            <div class="card">
                <div class="card-header">Configurações de Perfil</div>
                <div class="card-body">
                    <form action="update_usuario.php" method="POST">
                        <div class="form-group">
                            <label for="nome">Nome Completo</label>
                            <input type="text" class="form-control" id="nome" name="nome" value="Nome do Usuário"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" value="usuario@example.com"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="telefone">Telefone</label>
                            <input type="text" class="form-control" id="telefone" name="telefone"
                                value="(99) 99999-9999">
                        </div>
                        <div class="form-group">
                            <label for="endereco">Endereço</label>
                            <input type="text" class="form-control" id="endereco" name="endereco"
                                value="Rua Exemplo, 123">
                        </div>
                        <div class="form-group">
                            <label for="cidade">Cidade</label>
                            <input type="text" class="form-control" id="cidade" name="cidade" value="São Paulo">
                        </div>
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <input type="text" class="form-control" id="estado" name="estado" value="SP">
                        </div>
                        <div class="form-group">
                            <label for="cep">CEP</label>
                            <input type="text" class="form-control" id="cep" name="cep" value="12345-678">
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Alterna a classe active para mostrar/ocultar o menu lateral
        document.getElementById("sidebarCollapse").onclick = function() {
            var sidebar = document.getElementById("sidebar");
            var content = document.getElementById("content");
            sidebar.classList.toggle("active");
            content.classList.toggle("shifted");
        };
    </script>
</body>

</html>