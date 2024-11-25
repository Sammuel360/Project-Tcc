<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modelo de TI - Fiscal Cidadão</title>
    <style>
    /* Estilos Gerais */
    body {
        font-family: Arial, sans-serif;
        background-color: #f5f5f5;
        margin: 0;
        padding: 20px;
    }

    h2 {
        text-align: center;
        margin-bottom: 20px;
    }

    /* Estilos para o quadro principal */
    .board {
        display: flex;
        gap: 20px;
        overflow-x: auto;
    }

    /* Estilos para as colunas */
    .column {
        width: 300px;
        background-color: #ffffff;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 10px;
        flex-shrink: 0;
    }

    .column h3 {
        font-size: 18px;
        margin: 0 0 10px;
        padding: 10px;
        border-radius: 8px;
        color: #fff;
        text-align: center;
    }

    /* Cabeçalhos das colunas com cores diferentes */
    .column.triagem h3 {
        background-color: #f0b429;
    }

    .column.em-andamento h3 {
        background-color: #007bff;
    }

    .column.escalar h3 {
        background-color: #28a745;
    }

    .column.concluido h3 {
        background-color: #dc3545;
    }

    .column.arquivado h3 {
        background-color: #6c757d;
    }

    /* Estilos para os cards */
    .card {
        background-color: #f9f9f9;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 10px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    .card-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 8px;
    }

    .card-header span {
        font-size: 14px;
        color: #777;
    }

    .tag {
        display: inline-block;
        padding: 4px 8px;
        font-size: 12px;
        border-radius: 4px;
        color: #fff;
        margin-bottom: 8px;
    }

    .tag.problema {
        background-color: #f39c12;
    }

    .tag.solicitacao {
        background-color: #17a2b8;
    }

    .tag.pergunta {
        background-color: #6f42c1;
    }

    .tag.bug {
        background-color: #d9534f;
    }

    .card h4 {
        margin: 0;
        font-size: 16px;
    }

    .card p {
        font-size: 14px;
        color: #555;
        margin: 5px 0;
    }

    .info {
        font-size: 12px;
        color: #666;
    }
    </style>
</head>

<body>

    <h2>Gestão de Chamados - Fiscal Cidadão</h2>

    <div class="board">
        <!-- Coluna Triagem -->
        <div class="column triagem">
            <h3>Triagem</h3>
            <div class="card">
                <div class="card-header">
                    <h4>Internet Instável</h4>
                    <span>EXEMPLO</span>
                </div>
                <div class="tag problema">Problema</div>
                <p><strong>Tipo:</strong> Problemas com conexão de internet</p>
                <p class="info"><strong>Informações do solicitante:</strong> Luis Lebleu</p>
            </div>
        </div>

        <!-- Coluna Em Andamento -->
        <div class="column em-andamento">
            <h3>Em Andamento</h3>
            <div class="card">
                <div class="card-header">
                    <h4>Telefone não está funcionando</h4>
                    <span>EXEMPLO</span>
                </div>
                <div class="tag problema">Problema</div>
                <p><strong>Tipo:</strong> Manutenção de equipamentos</p>
                <p class="info"><strong>Informações do solicitante:</strong> Vera Valley</p>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>Teclado não funciona</h4>
                    <span>EXEMPLO</span>
                </div>
                <div class="tag pergunta">Pergunta</div>
                <p><strong>Tipo:</strong> Manutenção de equipamentos</p>
                <p class="info"><strong>Informações do solicitante:</strong> Ned Nix</p>
            </div>
        </div>

        <!-- Coluna Escalar o Problema -->
        <div class="column escalar">
            <h3>Escalar o Problema</h3>
            <div class="card">
                <div class="card-header">
                    <h4>Notebook muito lento</h4>
                    <span>EXEMPLO</span>
                </div>
                <div class="tag solicitacao">Solicitação</div>
                <p><strong>Tipo:</strong> Manutenção de equipamentos</p>
                <p class="info"><strong>Informações do solicitante:</strong> Melanie Davis</p>
            </div>
        </div>

        <!-- Coluna Concluído -->
        <div class="column concluido">
            <h3>Concluído</h3>
            <div class="card">
                <div class="card-header">
                    <h4>Instalação de novo software</h4>
                    <span>EXEMPLO</span>
                </div>
                <div class="tag pergunta">Pergunta</div>
                <p><strong>Tipo:</strong> Instalação de softwares</p>
                <p class="info"><strong>Informações do solicitante:</strong> John Smith</p>
            </div>
        </div>

        <!-- Coluna Arquivado -->
        <div class="column arquivado">
            <h3>Arquivado</h3>
            <div class="card">
                <div class="card-header">
                    <h4>Renovação de licença Office</h4>
                    <span>EXEMPLO</span>
                </div>
                <div class="tag bug">Bug</div>
                <p><strong>Tipo:</strong> Manutenção de software</p>
                <p class="info"><strong>Informações do solicitante:</strong> Lala Lambeth</p>
            </div>
        </div>
    </div>

</body>

</html>