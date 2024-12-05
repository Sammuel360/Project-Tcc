<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurações - Fiscal Cidadão</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
    body {
        background-color: #f4f7f9;
        font-family: 'Roboto', sans-serif;
    }

    #sidebarCollapse {
        position: fixed;
        top: 20px;
        left: 20px;
        z-index: 1050;
        background-color: #2563eb;
        color: white;
        border: none;
        padding: 10px 15px;
        font-size: 20px;
        border-radius: 5px;
        cursor: pointer;
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

    #content {
        margin-left: 20px;
        padding: 20px;
        transition: margin-left 0.3s;
    }

    #content.shifted {
        margin-left: 270px;
    }

    .container {
        max-width: 600px;
        margin-top: 40px;
    }

    .card {
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }

    .form-check-label {
        font-weight: 500;
    }
    </style>
</head>

<body>
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
        <div class="container">
            <h2>Configurações de Preferências</h2>
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Aparência</h5>
                    <form>
                        <div class="form-group">
                            <label for="themeSelect">Tema</label>
                            <select class="form-control" id="themeSelect">
                                <option value="light">Claro</option>
                                <option value="dark">Escuro</option>
                                <option value="system">Usar tema do sistema</option>
                            </select>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="darkModeToggle">
                            <label class="form-check-label" for="darkModeToggle">Modo Escuro</label>
                        </div>
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" id="showNotifications">
                            <label class="form-check-label" for="showNotifications">Mostrar notificações</label>
                        </div>
                        <button type="button" class="btn btn-primary mt-3" onclick="saveSettings()">Salvar
                            Configurações</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    document.getElementById("sidebarCollapse").onclick = function() {
        var sidebar = document.getElementById("sidebar");
        var content = document.getElementById("content");
        sidebar.classList.toggle("active");
        content.classList.toggle("shifted");
    };

    function saveSettings() {
        alert("Configurações salvas com sucesso!");
    }
    </script>
</body>

</html>