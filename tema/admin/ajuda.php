<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manual do Usuário - Cidadão Ativo</title>

    <link rel="stylesheet" href="includes/menulateral.css"> <!-- CSS separado -->
    <link rel="stylesheet" href="ajuda.css">

</head>

<body>
    <?php include_once __DIR__ . '/includes/menulateral.php'; ?>
    <header>


        <h1>Manual do Usuário - Cidadão Ativo</h1>
        <p>Este documento apresenta informações sobre o projeto e suas funcionalidades.</p>
    </header>

    <div class="index">
        <h2>Índice</h2>
        <ul>
            <li><a href="#visao-geral">1. Visão Geral</a></li>
            <li><a href="#objetivo-projeto">2. Objetivo do Projeto</a></li>
            <li><a href="#caracteristicas-usuario">3. Características da Persona/Usuário</a></li>
            <li><a href="#requisitos-negocio">4. Requisitos de Negócio</a></li>
            <li><a href="#requisitos-tecnicos">5. Requisitos Técnicos Básicos</a></li>
            <li><a href="#requisitos-funcionais">6. Requisitos Funcionais</a></li>
            <li><a href="#requisitos-relatorios">7. Requisitos de Relatórios</a></li>
            <li><a href="#requisitos-seguranca">8. Requisitos de Segurança</a></li>
            <li><a href="#identificacao-usuarios">9. Identificação de Usuários</a></li>
            <li><a href="#implementacao-interfaces">10. Implementação das Interfaces de Usuário</a></li>
            <li><a href="#instalacao-configuracao">11. Instalação e Configuração</a></li>
            <li><a href="#resolucao-problemas">12. Resolução de Problemas Comuns</a></li>
            <li><a href="#faq">13. Perguntas Frequentes (FAQ)</a></li>
            <li><a href="#consideracoes-adicionais">14. Considerações Adicionais</a></li>
        </ul>
    </div>

    <div class="container">
        <h2 id="visao-geral" class="section-title">1. Visão Geral</h2>
        <p class="section-text">Cidadão Ativo é um aplicativo móvel e plataforma web que visa melhorar a gestão e
            manutenção de vias e locais públicos por meio de uma colaboração ativa entre cidadãos e autoridades locais.
            O sistema permite que os cidadãos reportem problemas relacionados à infraestrutura urbana, como buracos em
            ruas, falhas na iluminação pública, lixo acumulado e outros problemas similares, diretamente para as
            autoridades responsáveis.</p>
        <img src="exemplo-interface.png" alt="Exemplo de Interface do Aplicativo"
            style="max-width: 100%; height: auto; border-radius: 8px;">

        <h2 id="objetivo-projeto" class="section-title">2. Objetivo do Projeto</h2>
        <p class="section-text">O principal objetivo do projeto é fornecer um serviço B2C que permite aos cidadãos
            relatar problemas de infraestrutura urbana de forma eficiente e acessível.</p>

        <h2 id="caracteristicas-usuario" class="section-title">3. Características da Persona/Usuário</h2>
        <h3 class="subsection-title">Características do Usuário</h3>
        <ul>
            <li>Suporte para leitores de tela e navegação por voz.</li>
            <li>Design simples e intuitivo.</li>
            <li>Cadastro e Autenticação.</li>
            <li>Geolocalização para facilitar o registro de problemas.</li>
            <li>Notificações sobre o status dos relatos.</li>
        </ul>

        <h3 class="subsection-title">Características do Produto</h3>
        <ul>
            <li>Banco de dados robusto para armazenar e categorizar relatos (ex: iluminação pública, buracos, lixo).
            </li>
            <li>Sistema de Gestão de Relatos.</li>
            <li>Relatórios e Análises para gestão de dados.</li>
            <li>Integração com Serviços Públicos.</li>
            <li>Segurança de Dados para proteger informações sensíveis.</li>
        </ul>

        <h2 id="requisitos-negocio" class="section-title">4. Requisitos de Negócio</h2>
        <h3 class="subsection-title">Necessidade do Usuário</h3>
        <p class="section-text">Garantir que os usuários consigam relatar problemas de infraestrutura e que os relatos
            possam chegar aos órgãos competentes.</p>

        <h3 class="subsection-title">Caso de Uso</h3>
        <p class="section-text">Melhorar a qualidade de vida da população através da comunicação eficiente de problemas
            urbanos.</p>

        <h2 id="requisitos-tecnicos" class="section-title">5. Requisitos Técnicos Básicos</h2>
        <ul>
            <li>Implementar cadastro de usuário.</li>
            <li>Implementar login de usuários.</li>
            <li>Implementar conexão com o banco de dados.</li>
            <li>API RESTful para comunicação entre frontend e backend.</li>
            <li>Implementar abertura de chamadas para relatos.</li>
            <li>Implementar sistema de notificações.</li>
            <li>Painel para gestores para monitoramento e gestão de relatos.</li>
            <li>Compatibilidade com múltiplos dispositivos e navegadores.</li>
            <li>Implementar sistema de pontuação para usuários.</li>
            <li>Implementar gráficos de chamadas (registradas, realizadas, pendentes).</li>
            <li>Painel de administração para órgãos competentes visualizarem e gerenciarem chamados.</li>
        </ul>

        <h2 id="requisitos-funcionais" class="section-title">6. Requisitos Funcionais</h2>
        <ul>
            <li><strong>Registro de Usuário e Autenticação:</strong> Sistema de registro e login seguro, com opções de
                autenticação social (Google, Facebook).</li>
            <li><strong>Interface de Envio de Informações:</strong> Formulário para relatar problemas, com opção de
                anexar fotos e descrições.</li>
            <li><strong>Geolocalização:</strong> Mapa integrado para marcar a localização exata do problema.</li>
            <li><strong>Classificação e Prioridade:</strong> Sistema para classificar e priorizar problemas reportados.
            </li>
            <li><strong>Rastreamento de Status:</strong> Funcionalidade para acompanhar o status dos problemas
                reportados.</li>
            <li><strong>Notificações:</strong> Alertas sobre atualizações no status dos problemas.</li>
            <li><strong>Feedback:</strong> Mecanismo para avaliar a resolução dos problemas e fornecer feedback.</li>
        </ul>

        <h2 id="requisitos-relatorios" class="section-title">7. Requisitos de Relatórios</h2>
        <ul>
            <li><strong>Relatórios de Problemas Relatados:</strong> Resumo dos problemas, status atual, etc.</li>
            <li><strong>Relatórios de Desempenho:</strong> Tempo médio de resolução e taxa de resolução.</li>
            <li><strong>Relatórios de Prioridade e Gravidade:</strong> Problemas categorizados por prioridade e
                gravidade.</li>
            <li><strong>Relatórios Geoespaciais:</strong> Mapa de problemas e tendências regionais.</li>
            <li><strong>Relatórios de Feedback dos Cidadãos:</strong> Avaliações e comentários sobre a resolução dos
                problemas.</li>
        </ul>

        <h2 id="requisitos-seguranca" class="section-title">8. Requisitos de Segurança</h2>
        <ul>
            <li><strong>Proteção de Dados:</strong> Criptografia de dados em trânsito e em repouso.</li>
            <li><strong>Controle de Acesso:</strong> Autenticação segura e controle de acesso baseado em funções (RBAC).
            </li>
            <li><strong>Gestão de Senhas:</strong> Políticas de senhas fortes e armazenamento seguro.</li>
            <li><strong>Proteção contra Ameaças:</strong> Firewall, proteção contra SQL Injection e XSS.</li>
            <li><strong>Monitoramento e Detecção:</strong> Registro e monitoramento de atividades do sistema.</li>
            <li><strong>Conformidade com Regulamentações:</strong> Cumprimento da LGPD e outras regulamentações de
                privacidade.</li>
            <li><strong>Segurança da Infraestrutura:</strong> Data centers seguros e atualizações regulares de
                segurança.</li>
        </ul>

        <h2 id="identificacao-usuarios" class="section-title">9. Identificação de Usuários</h2>
        <h3 class="subsection-title">Tipos de Usuários</h3>
        <ul>
            <li><strong>Cidadãos:</strong> Usuários que utilizam o aplicativo para relatar problemas.</li>
            <li><strong>Técnicos e Agentes de Manutenção:</strong> Funcionários que gerenciam os relatórios e realizam
                manutenções.</li>
            <li><strong>Gestores e Administradores:</strong> Responsáveis pela supervisão e análise de dados.</li>
            <li><strong>Coordenadores e Supervisores:</strong> Coordenam atividades dos técnicos e garantem
                conformidade.</li>
        </ul>

        <h2 id="implementacao-interfaces" class="section-title">10. Implementação das Interfaces de Usuário</h2>
        <h3 class="subsection-title">Interface para Cidadãos</h3>
        <ul>
            <li><strong>Objetivos:</strong> Simplicidade, facilidade de uso e acessibilidade.</li>
            <li><strong>Implementação:</strong>
                <ul>
                    <li>Tela Inicial: Design limpo e intuitivo com botões de ação claros.</li>
                    <li>Formulário de Reporte: Campos diretos para descrição, fotos e localização.</li>
                    <li>Tela de Status e Feedback: Atualizações em tempo real e sistema de avaliação.</li>
                </ul>
            </li>
        </ul>

        <h3 class="subsection-title">Interface para Técnicos e Agentes de Manutenção</h3>
        <ul>
            <li><strong>Objetivos:</strong> Eficiência na gestão e resolução de problemas.</li>
            <li><strong>Implementação:</strong>
                <ul>
                    <li>Painel de Controle: Visão geral das tarefas atribuídas.</li>
                    <li>Detalhes do Problema: Informações detalhadas e ferramentas de atualização.</li>
                    <li>Comunicação: Sistema de mensagens internas para comunicação.</li>
                </ul>
            </li>
        </ul>

        <h3 class="subsection-title">Interface para Gestores e Administradores</h3>
        <ul>
            <li><strong>Objetivos:</strong> Análise e visualização de dados.</li>
            <li><strong>Implementação:</strong>
                <ul>
                    <li>Dashboard Analítico: Visualização de dados com gráficos e tabelas.</li>
                    <li>Geração de Relatórios: Ferramenta para criar e exportar relatórios.</li>
                </ul>
            </li>
        </ul>

        <h3 class="subsection-title">Interface para Coordenadores e Supervisores</h3>
        <ul>
            <li><strong>Objetivos:</strong> Coordenação e supervisão das atividades de manutenção.</li>
            <li><strong>Implementação:</strong>
                <ul>
                    <li>Painel de Coordenação: Visão geral das atividades dos técnicos.</li>
                    <li>Relatórios de Progresso: Acompanhamento de desempenho e feedback.</li>
                </ul>
            </li>
        </ul>

        <h2 id="instalacao-configuracao" class="section-title">11. Instalação e Configuração</h2>
        <p class="section-text">Para instalar o aplicativo, siga os passos abaixo:</p>
        <ol>
            <li>Baixe o aplicativo na loja de aplicativos (Google Play ou App Store).</li>
            <li>Abra o aplicativo e siga as instruções para criar uma conta.</li>
            <li>Permita o acesso à localização para melhor funcionalidade.</li>
        </ol>
        <p class="section-text">Para configurar seu perfil:</p>
        <ol>
            <li>Acesse as configurações no menu principal.</li>
            <li>Preencha suas informações pessoais e preferências de notificação.</li>
        </ol>

        <h2 id="resolucao-problemas" class="section-title">12. Resolução de Problemas Comuns</h2>
        <ul>
            <li><strong>Problema:</strong> Não consigo fazer login.</li>
            <li><strong>Solução:</strong> Verifique se suas credenciais estão corretas e se a conexão com a internet
                está ativa.</li>
            <li><strong>Problema:</strong> O aplicativo não carrega.</li>
            <li><strong>Solução:</strong> Tente reiniciar o aplicativo ou seu dispositivo.</li>
            <li><strong>Problema:</strong> Não recebo notificações.</li>
            <li><strong>Solução:</strong> Verifique as configurações de notificação do aplicativo e do dispositivo.</li>
        </ul>

        <h2 id="faq" class="section-title">13. Perguntas Frequentes (FAQ)</h2>
        <div class="faq">
            <h3>1. Como posso relatar um problema?</h3>
            <p>Você pode relatar um problema através do formulário disponível na tela inicial do aplicativo.</p>
            <h3>2. O que fazer se meu problema não for resolvido?</h3>
            <p>Se o problema persistir, você pode entrar em contato com o suporte através do menu de ajuda no
                aplicativo.</p>
            <h3>3. Como posso alterar minhas informações pessoais?</h3>
            <p>Você pode alterar suas informações pessoais acessando a seção de configurações no aplicativo.</p>
        </div>

        <h2 id="consideracoes-adicionais" class="section-title">14. Considerações Adicionais</h2>
        <p class="section-text">As interfaces devem ser responsivas e adaptáveis a diferentes tamanhos de tela,
            garantindo uma boa experiência de usuário em dispositivos móveis e desktops.</p>
    </div>

    <footer>
        <p>&copy; 2024 Cidadão Ativo. Todos os direitos reservados.</p>
    </footer>
    <script>
    // Alterna a classe active para mostrar/ocultar o menu lateral
    document.getElementById("sidebarCollapse").onclick = function() {
        var sidebar = document.getElementById("sidebar");
        var content = document.getElementById("content");
        sidebar.classList.toggle("active");
        content.classList.toggle("shifted");
    };
    </script>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="includes/script.js"></script> <!-- JS separado -->

</body>

</html>