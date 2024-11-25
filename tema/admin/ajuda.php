<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">


    <title>Fiscal Cidadão - Manual de Usuário</title>
    <style>
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

        /*organizacao*/
        /* Geral */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }

        main {
            padding-top: 80px;
            /* Ajusta o espaço superior devido à barra fixa */
            margin: 20px;
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

        /* Cards para os tópicos */
        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin: 20px 0;
            padding: 20px;
            transition: transform 0.3s ease-in-out;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .card h3 {
            font-size: 1.5rem;
            margin-bottom: 10px;
            color: #0066cc;
        }

        .card p {
            font-size: 1rem;
            line-height: 1.6;
            color: #333;
        }

        .card ol {
            margin: 10px 0 20px 20px;
            font-size: 1rem;
        }

        /* Modal */
        .modal-content {
            background-color: white;
            padding: 20px;
            max-width: 900px;
            margin: auto;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h2 {
            font-size: 1.8rem;
            color: #0066cc;
        }

        p {
            font-size: 1rem;
            color: #333;
        }

        footer {
            background-color: #0066cc;
            color: white;
            text-align: center;
            padding: 10px 0;
            position: fixed;
            width: 100%;
            bottom: 0;
        }

        footer p {
            margin: 0;
        }

        /* Responsividade */
        @media (max-width: 768px) {
            .top-bar {
                flex-direction: column;
                align-items: flex-start;
            }

            header .top-bar nav {
                margin-top: 10px;
            }

            .card {
                margin: 10px 0;
            }
        }

        /* Sidebar */
        .sidebar {
            width: 230px;
            background-color: #333;
            padding: 2rem 1.5rem;
            color: white;
            position: fixed;
            height: 100%;
            top: 0;
            left: -240px;
            transition: all 0.3s ease;
            z-index: 9999;
            /* Isso coloca a sidebar acima de outros elementos */
        }

        .main-content.active {
            margin-left: 240px;
            /* Espaço para a sidebar quando ela está ativa */
        }

        /* Ajustes para a sidebar quando estiver ativa */
        .sidebar.active {
            left: 0;
        }

        .main-content.active {
            margin-left: 240px;
            /* Ajuste para permitir que o conteúdo principal desloque */
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

    <main>


        <div id="ajudaModal" class="modal">
            <div class="modal-content">
                <nav class="navbar">


                    <h2>Rede Social - Fiscal Cidadão</h2>
                </nav>
                <span class="close">&times;</span>
                <h2>Manual de Usuário</h2>
                <p>
                    <!-- Editar esta parte para fornecer informações básicas sobre o site -->
                    Este site permite que cidadãos relatem problemas como infraestrutura, iluminação e outros.
                    <br><br>
                    Passos para relatar um problema:
                <ol>
                    <li>Selecione o tipo de problema que deseja relatar.</li>
                    <li>Preencha o formulário com as informações necessárias.</li>
                    <li>Clique em "Enviar" para enviar sua denúncia.</li>
                </ol>
                </p>
                <h2>Requisitos</h2>
                <p>
                    * Acesso à internet
                    <br>
                    * Navegador web moderno (Google Chrome, Mozilla Firefox, etc.)
                </p>
                <h2>Passos para relatar um problema</h2>
                <ol>
                    <li>Selecione o tipo de problema: Escolha o tipo de problema que você deseja relatar, como
                        infraestrutura, iluminação, etc.</li>
                    <li>Preencha o formulário: Preencha o formulário com as informações necessárias, como localização,
                        descrição do problema, etc.</li>
                    <li>Clique em "Enviar": Clique no botão "Enviar" para enviar sua denúncia.</li>
                </ol>
                <h2>Funcionalidades</h2>
                <p>
                    * Modal de Ajuda: Clique no botão "Ajuda" para abrir o modal de ajuda, que contém informações
                    básicas sobre o site e passos para relatar um problema.
                    <br>
                    * Formulário de Relato: Preencha o formulário com as informações necessárias para relatar um
                    problema.
                    <br>
                    * Envio de Denúncia: Clique no botão "Enviar" para enviar sua denúncia.
                </p>
                <h2>Dicas e Sugestões</h2>
                <p>
                    * Certifique-se de preencher todos os campos obrigatórios do formulário.
                    <br>
                    * Forneça informações detalhadas e precisas sobre o problema.
                    <br>
                    * Verifique se o problema já foi relatado anteriormente.
                </p>
                <h2>Perguntas Frequentes</h2>
                <p>
                    * Como faço para relatar um problema?: Siga os passos descritos acima.
                    <br>
                    * O que acontece após enviar minha denúncia?: Sua denúncia será enviada para a prefeitura e será
                    analisada por nossos funcionários.
                    <br>
                    * Como posso acompanhar o status da minha denúncia?: Você receberá um e-mail com o status da sua
                    denúncia.
                </p>
                <h2>Contato</h2>
                <p>
                    * E-mail: <a href="mailto:fiscal.cidadão@example.com">fiscal.cidadão@example.com</a>
                    <br>
                    * Telefone: 11 1234-5678
                    <br>
                    * Endereço: Prefeitura Municipal, do seu estado
                </p>
                <h2>Termos e Condições</h2>
                <p>
                    * Ao utilizar o sistema, você concorda com os termos e condições de uso.
                    <br>
                    * O sistema não é responsável por erros ou omissões nos relatos de problemas.
                    <br>
                    * O sistema não será oferecido em tempo real.
                    <br>
                    * O sistema não sera utilizado para poder fazer denuncias focadas a outros cidades com itenção de o
                    prejudicar, em casos graves ligue para a policia no 190 da sua reg ião
                </p>
                <h2>Créditos</h2>
                <p>
                    * Desenvolvido por Joao da Fiscal Cidadão
                    <br>
                    * Copyright 2024 Fiscal Cidadão. Todos os direitos reservados.
                </p>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; 2024 Fiscal Cidadão. Todos os direitos reservados.</p>
    </footer>

    <script>
        // Função para abrir e fechar o modal de ajuda
        const ajudaBtn = document.getElementById("ajudaBtn");
        const ajudaModal = document.getElementById("ajudaModal");
        const closeBtn = document.getElementsByClassName("close")[0];

        ajudaBtn.onclick = function() {
            ajudaModal.style.display = "block";
        }

        closeBtn.onclick = function() {
            ajudaModal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target === ajudaModal) {
                ajudaModal.style.display = "none";
            }
        }
    </script>
    <script>
        // Função para alternar a classe 'active' na sidebar
        const menuToggle = document.getElementById('menu-toggle');
        const sidebar = document.querySelector('.sidebar');
        const mainContent = document.querySelector('main'); // Corrigido para o elemento 'main'

        menuToggle.addEventListener('click', () => {
            sidebar.classList.toggle('active');
            mainContent.classList.toggle('active'); // Alternando o 'main' diretamente
        });
    </script>


</body>


</html>