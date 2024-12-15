<!-- menulateral.php -->
<header>
    <div class="top-bar">
        <div class="menu-button-container">
            <div id="menu-toggle">&#9776;</div> <!-- Ícone do menu -->
        </div>
        <h1>Fiscal Cidadão</h1>
        <nav>
            <a href="http://localhost/fiscalapp/index.php?c=usuario&a=main">🏠 Início</a>
            <a href="http://localhost/fiscalapp/index.php?c=status&a=listar">📊 Status</a>
            <a href="http://localhost/fiscalapp/index.php?c=notificacoes&a=index">🔔 Notificações</a>
            <a href="http://localhost/fiscalapp/index.php?c=chamado&a=abrirFormulario">📝 Chamados</a>
            <a href="http://localhost/fiscalapp/index.php?c=configuracao&a=index">⚙️ Configurações</a>
            <a href="http://localhost/fiscalapp/index.php?c=ajuda&a=index">❓ Ajuda</a>
            <a href="http://localhost/fiscalapp/index.php?c=usuario&a=perfil">👤 Perfil</a>
        </nav>
    </div>
</header>

<button id="sidebarCollapse" class="btn btn-info">☰</button> <!-- Botão para abrir o menu lateral -->

<nav id="sidebar">
    <div class="sidebar-header">
        <h3>Fiscal Cidadão</h3>
    </div>
    <ul class="list-unstyled components">
        <li><a href="http://localhost/fiscalapp/index.php?c=usuario&a=main">🏠 Início</a></li>
        <li><a href="http://localhost/fiscalapp/index.php?c=status&a=listar">📊 Status</a></li>
        <li><a href="http://localhost/fiscalapp/index.php?c=notificacoes&a=index">🔔 Notificações</a></li>
        <li><a href="http://localhost/fiscalapp/index.php?c=usuario&a=perfil">👤 Perfil</a></li>
        <li><a href="http://localhost/fiscalapp/index.php?c=configuracao&a=index">⚙️ Configurações</a></li>
        <li><a href="http://localhost/fiscalapp/index.php?c=ajuda&a=index">❓ Ajuda</a></li>
        <li><a href="http://localhost/fiscalapp/index.php?c=chamado&a=abrirFormulario">📝 Chamados</a></li>
    </ul>
</nav>

<!-- Estilos diretamente no arquivo -->
<!-- Estilos diretamente no arquivo -->
<style>
/* Cores */
:root {
    --cor-primaria: #1a73e8;
    /* Azul escuro */
    --cor-secundaria: #ff9800;
    /* Laranja */
    --cor-fundo: #f4f4f9;
    /* Cinza claro */
    --cor-texto: #333333;
    /* Texto primário */
    --cor-texto-secundario: #757575;
    /* Texto secundário */
    --cor-borda: #e0e0e0;
    /* Borda leve */
}

/* Body */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
    background-color: var(--cor-fundo);
}

/* Header */
header {
    background-color: var(--cor-primaria);
    color: white;
    padding: 10px;
    position: fixed;
    top: 0;
    width: 100%;
    z-index: 1000;
}

.top-bar {
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.top-bar h1 {
    font-size: 1.5rem;
}

.top-bar nav a {
    color: white;
    margin-left: 15px;
    text-decoration: none;
    font-weight: bold;
}

.top-bar nav a:hover {
    color: var(--cor-secundaria);
}

/* Menu Lateral */
#sidebar {
    height: 100%;
    width: 250px;
    position: fixed;
    left: 0;
    top: 0;
    background-color: #333;
    color: white;
    padding-top: 20px;
    display: none;
    /* Inicialmente oculto */
    z-index: 999;
    transition: all 0.3s ease;
}

#sidebar.active {
    display: block;
}

#sidebar .sidebar-header {
    padding: 10px 15px;
    background-color: var(--cor-primaria);
    text-align: center;
    font-size: 1.5rem;
}

#sidebar ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

#sidebar ul li {
    padding: 15px;
    text-align: left;
}

#sidebar ul li a {
    color: white;
    text-decoration: none;
    display: block;
}

#sidebar ul li a:hover {
    background-color: var(--cor-secundaria);
    color: white;
}

/* Botão para abrir o menu */
#sidebarCollapse {
    position: fixed;
    top: 20px;
    left: 20px;
    background-color: var(--cor-primaria);
    color: white;
    border: none;
    padding: 15px;
    cursor: pointer;
    border-radius: 10px;
    font-size: 1.5rem;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    transition: all 0.3s ease;
    z-index: 1100;
    /* Garantir que o botão fique acima de outros elementos */
}

/* Efeito de destaque no hover */
#sidebarCollapse:hover {
    background-color: var(--cor-secundaria);
    transform: scale(1.1);
    /* Aumenta o botão ao passar o mouse */
}

#sidebarCollapse:focus {
    outline: none;
}

/* Media Queries para dispositivos menores */
@media (max-width: 768px) {
    #sidebar {
        width: 200px;
    }

    .top-bar {
        display: none;
    }

    #sidebarCollapse {
        display: block;
    }
}

/* Estilo para a página com o menu aberto */
body.menu-open {
    margin-left: 250px;
    transition: all 0.3s ease;
}
</style>

<script>
const menuToggle = document.getElementById("menu-toggle");
const sidebar = document.getElementById("sidebar");
const sidebarCollapse = document.getElementById("sidebarCollapse");

// Abre o menu lateral
menuToggle.addEventListener("click", function() {
    sidebar.classList.toggle("active");
    document.body.classList.toggle("menu-open");
});

// Fecha o menu lateral ao clicar no botão
sidebarCollapse.addEventListener("click", function() {
    sidebar.classList.toggle("active");
    document.body.classList.toggle("menu-open");
});
</script>