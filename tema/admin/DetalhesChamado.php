    <?php
    // Conexão com o banco de dados
    // Se estiver usando o Composer para autoload


    // Incluindo a classe Connect
    use Source\Core\Connect;

    // Se estiver usando o Composer para autoload


    require_once '../Source/Core/Connect.php';



    // Obtendo a instância da conexão
    $pdo = Connect::getInstance();

    // Verificando se a conexão foi bem-sucedida
    if (!$pdo) {
        echo "Erro na conexão com o banco de dados.";
        exit;
    }
    echo class_exists('Source\Core\Connect') ? 'Classe encontrada' : 'Classe não encontrada';



    $id = $_GET['id']; // ID do chamado passado pela URL

    // Consulta os dados do chamado
    $sql = "SELECT c.titulo, c.descricao, c.status, o.nome AS orgao_responsavel, c.created_at 
            FROM chamados c
            JOIN orgaos o ON c.orgao_id = o.id
            WHERE c.id = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':id', $id);
    $stmt->execute();
    $chamado = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$chamado) {
        echo "Chamado não encontrado.";
        exit;
    }

    // Definindo dados para o gráfico
    $statusCounts = [
        'pendente' => 0,
        'em_progresso' => 0,
        'concluido' => 0
    ];

    switch ($chamado['status']) {
        case 'pendente':
            $statusCounts['pendente'] = 1;
            break;
        case 'em_progresso':
            $statusCounts['em_progresso'] = 1;
            break;
        case 'concluido':
            $statusCounts['concluido'] = 1;
            break;
    }
    ?>

    <!DOCTYPE html>
    <html lang="pt-BR">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Detalhes do Chamado</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
            integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

    </head>

    <body>
        <div class="detalhes-chamado">
            <header>
                <h1>Detalhes do Chamado #<?php echo $id; ?></h1>
            </header>

            <section class="cards-section">
                <div class="card">
                    <h3>Título</h3>
                    <p><?php echo htmlspecialchars($chamado['titulo']); ?></p>
                </div>
                <div class="card">
                    <h3>Descrição</h3>
                    <p><?php echo nl2br(htmlspecialchars($chamado['descricao'])); ?></p>
                </div>
                <div class="card">
                    <h3>Status</h3>
                    <p><?php echo ucfirst($chamado['status']); ?></p>
                </div>
                <div class="card">
                    <h3>Órgão Responsável</h3>
                    <p><?php echo htmlspecialchars($chamado['orgao_responsavel']); ?></p>
                </div>
                <div class="card">
                    <h3>Data de Criação</h3>
                    <p><?php echo date('d/m/Y H:i:s', strtotime($chamado['created_at'])); ?></p>
                </div>
            </section>

            <section class="graficos-section">
                <div class="grafico-container">
                    <h3>Distribuição do Chamado</h3>
                    <canvas id="statusChart"></canvas>
                </div>
            </section>
        </div>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
        <script>
        const ctx = document.getElementById('statusChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: ['Pendente', 'Em Progresso', 'Concluído'],
                datasets: [{
                    data: [<?php echo $statusCounts['pendente']; ?>,
                        <?php echo $statusCounts['em_progresso']; ?>,
                        <?php echo $statusCounts['concluido']; ?>
                    ],
                    backgroundColor: ['#ff6384', '#36a2eb', '#4caf50'],
                }]
            }
        });
        </script>
    </body>

    </html>