    <!DOCTYPE html>
    <html lang="pt-BR">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Abrir Chamado</title>
        <link rel="stylesheet" href="styles.css">
        <style>
        /* Estilo do formulário */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .container {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input,
        textarea,
        select {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .button {
            padding: 10px 20px;
            background-color: #007bff;
            color: white;
            border: none;
            cursor: pointer;
        }

        .button:hover {
            background-color: #0056b3;
        }

        /* Estilo do menu lateral */
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

        /* Estilo do botão de alternância */
        #sidebarCollapse {
            position: fixed;
            top: 20px;
            left: 20px;
            z-index: 1050;
            background-color: #17a2b8;
            color: white;
            border: none;
            padding: 10px 15px;
            border-radius: 5px;
            font-size: 20px;
            cursor: pointer;
        }

        #content.shifted {
            margin-left: 270px;
        }
        </style>
    </head>

    <body>
        <!-- Botão de alternância do menu lateral -->
        <button id="sidebarCollapse" class="btn btn-info">☰</button>

        <!-- Menu Lateral -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>Fiscal Cidadão</h3>
            </div>
            <ul class="list-unstyled components">
                <li><a href="dashboard.php">🏠 Início</a></li>
                <li><a href="DetalhesChamado.php">📊 Status</a></li>
                <li><a href="#">🔔 Notificações</a></li>
                <li><a href="perfil.php">👤 Perfil</a></li>
                <li><a href="configuracoes.php">⚙️ Configurações</a></li>
                <li><a href="ajuda.php">❓ Ajuda</a></li>
                <li><a href="index.php?c=chamado&a=abrirFormulario">📝 Chamados</a></li>
                <!-- index.php?c=chamado&a=abrirFormulario_-->
            </ul>
        </nav>

        <div class="container">
            <h1>Abrir Chamado</h1>

            <?php if (!empty($_SESSION['message'])): ?>
            <div class="alert">
                <?= $_SESSION['message']; ?>
                <?php unset($_SESSION['message']); ?>
            </div>
            <?php endif; ?>

            <form action="index.php?c=chamado&a=inserir" method="POST">
                <label for="titulo">Título:</label>
                <input type="text" name="titulo" id="titulo" required>

                <label for="descricao">Descrição:</label>
                <textarea name="descricao" id="descricao" required></textarea>

                <label for="cep">CEP:</label>
                <input type="text" name="cep" id="cep" required>

                <label for="endereco">Endereço:</label>
                <input type="text" name="endereco" id="endereco" required>

                <label for="orgao_id">Órgão Responsável:</label>
                <select name="orgao_id" id="orgao_id" required>
                    <option value="">Selecione o órgão</option>
                    <?php
                    if (isset($_SESSION['orgaos']) && !empty($_SESSION['orgaos'])) {
                        $orgaos = $_SESSION['orgaos'];
                        foreach ($orgaos as $orgao) {
                    ?>
                    <option value="<?= htmlspecialchars($orgao->id); ?>">
                        <?= htmlspecialchars($orgao->nome); ?>
                    </option>
                    <?php
                        }
                    }
                    ?>


                </select>


                <button type="submit" class="button">Abrir Chamado</button>
            </form>


        </div>
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