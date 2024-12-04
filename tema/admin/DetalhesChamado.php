<?php
// A view espera receber as variáveis $chamado e $statusList do controlador

// Definindo dados para o gráfico baseado no status atual do chamado
$statusCounts = [
    'pendente' => 0,
    'em_progresso' => 0,
    'concluido' => 0
];

// Supondo que o status atual é o último status registrado
if (!empty($statusList)) {
    foreach ($statusList as $status) {
        switch ($status['status']) {
            case 'pendente':
                $statusCounts['pendente'] += 1;
                break;
            case 'em_progresso':
                $statusCounts['em_progresso'] += 1;
                break;
            case 'concluido':
                $statusCounts['concluido'] += 1;
                break;
        }
    }
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
    <link rel="stylesheet" href="includes/menulateral.css"> <!-- CSS separado -->
</head>

<body>
    <?php include_once __DIR__ . '/includes/menulateral.php'; ?>
    <div class="detalhes-chamado container mt-5">
        <header class="mb-4">
            <h1>Detalhes do Chamado #<?php echo htmlspecialchars($chamado['id']); ?></h1>
        </header>

        <section class="cards-section row">
            <div class="card col-md-4 mb-3">
                <div class="card-body">
                    <h5 class="card-title">Título</h5>
                    <p class="card-text"><?php echo htmlspecialchars($chamado['titulo']); ?></p>
                </div>
            </div>
            <div class="card col-md-8 mb-3">
                <div class="card-body">
                    <h5 class="card-title">Descrição</h5>
                    <p class="card-text"><?php echo nl2br(htmlspecialchars($chamado['descricao'])); ?></p>
                </div>
            </div>
            <div class="card col-md-4 mb-3">
                <div class="card-body">
                    <h5 class="card-title">Status Atual</h5>
                    <p class="card-text"><?php echo ucfirst(htmlspecialchars($chamado['status'])); ?></p>
                </div>
            </div>
            <div class="card col-md-4 mb-3">
                <div class="card-body">
                    <h5 class="card-title">Órgão Responsável</h5>
                    <p class="card-text"><?php echo htmlspecialchars($chamado['orgao_responsavel']); ?></p>
                </div>
            </div>
            <div class="card col-md-4 mb-3">
                <div class="card-body">
                    <h5 class="card-title">Data de Criação</h5>
                    <p class="card-text"><?php echo date('d/m/Y H:i:s', strtotime($chamado['created_at'])); ?></p>
                </div>
            </div>
        </section>

        <section class="graficos-section mb-4">
            <div class="grafico-container">
                <h3>Distribuição do Chamado</h3>
                <canvas id="statusChart"></canvas>
            </div>
        </section>

        <section class="historico-status-section mb-4">
            <h3>Histórico de Status</h3>
            <?php if (!empty($statusList)): ?>
            <ul class="list-group">
                <?php foreach ($statusList as $status): ?>
                <li class="list-group-item">
                    <strong>Status:</strong> <?= htmlspecialchars(ucfirst($status['status'])) ?><br>
                    <strong>Observação:</strong> <?= htmlspecialchars($status['observacao']) ?><br>
                    <strong>Data:</strong> <?= date('d/m/Y H:i:s', strtotime($status['created_at'])) ?>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php else: ?>
            <p>Não há registros de status para este chamado.</p>
            <?php endif; ?>
        </section>

        <section class="atualizar-status-section">
            <h3>Atualizar Status</h3>
            <form action="index.php?c=status&a=inserir" method="POST">
                <input type="hidden" name="chamado_id" value="<?php echo htmlspecialchars($chamado['id']); ?>">
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="">Selecione um status</option>
                        <option value="pendente">Pendente</option>
                        <option value="em_progresso">Em Progresso</option>
                        <option value="concluido">Concluído</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="observacao">Observação</label>
                    <textarea name="observacao" id="observacao" class="form-control" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Atualizar Status</button>
            </form>
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="includes/script.js"></script> <!-- JS separado -->
</body>

</html>