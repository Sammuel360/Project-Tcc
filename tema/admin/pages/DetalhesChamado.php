<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes do Chamado</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="/../css/menulateral.css"> <!-- CSS externo -->
</head>

<body>
    <?php include_once __DIR__ . '/../includes/menulateral.php'; ?>

    <div class="container mt-5">
        <?php if (isset($chamado)): ?>
        <!-- Cabeçalho -->
        <header class="mb-4">
            <h1>Detalhes do Chamado #<?php echo htmlspecialchars($chamado->id); ?></h1>
        </header>

        <!-- Informações principais do chamado -->
        <section class="row">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Título</h5>
                        <p class="card-text"><?php echo htmlspecialchars($chamado->titulo); ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-8 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Descrição</h5>
                        <p class="card-text"><?php echo nl2br(htmlspecialchars($chamado->descricao)); ?></p>
                    </div>
                </div>
            </div>
        </section>

        <section class="row">
            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Status Atual</h5>
                        <p class="card-text"><?php echo ucfirst(htmlspecialchars($chamado->status)); ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Órgão Responsável</h5>
                        <p class="card-text"><?php echo htmlspecialchars($chamado->nome_orgao); ?></p>
                    </div>
                </div>
            </div>

            <div class="col-md-4 mb-3">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Usuário</h5>
                        <p class="card-text"><?php echo htmlspecialchars($chamado->nome_usuario); ?></p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Histórico de Status -->
        <section class="mt-4">
            <h3>Histórico de Status</h3>
            <?php if (!empty($historicoStatus)): ?>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Status</th>
                        <th>Data de Alteração</th>
                        <th>Observação</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($historicoStatus as $status): ?>
                    <tr>
                        <td><?php echo ucfirst(htmlspecialchars($status->status)); ?></td>
                        <td><?php echo date('d/m/Y H:i:s', strtotime($status->data_alteracao)); ?></td>
                        <td><?php echo nl2br(htmlspecialchars($status->observacao)); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <?php else: ?>
            <p>Não há registros de status para este chamado.</p>
            <?php endif; ?>
        </section>

        <!-- Atualizar Status -->
        <section class="mt-4">
            <h3>Atualizar Status</h3>
            <form action="index.php?c=status&a=inserir" method="POST">
                <input type="hidden" name="chamado_id" value="<?php echo htmlspecialchars($chamado->id); ?>">
                <div class="form-group">
                    <label for="status">Status</label>
                    <select name="status" id="status" class="form-control" required>
                        <option value="">Selecione um status</option>
                        <option value="pendente" <?php echo $chamado->status == 'pendente' ? 'selected' : ''; ?>>
                            Pendente</option>
                        <option value="em_progresso"
                            <?php echo $chamado->status == 'em_progresso' ? 'selected' : ''; ?>>Em Progresso</option>
                        <option value="concluido" <?php echo $chamado->status == 'concluido' ? 'selected' : ''; ?>>
                            Concluído</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="observacao">Observação</label>
                    <textarea name="observacao" id="observacao" class="form-control" rows="3" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Atualizar Status</button>
            </form>
        </section>
        <?php else: ?>
        <p>Chamado não encontrado.</p>
        <?php endif; ?>
    </div>

    <!-- JavaScript -->
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

    document.getElementById("sidebarCollapse").onclick = function() {
        document.getElementById("sidebar").classList.toggle("active");
        document.getElementById("content").classList.toggle("shifted");
    };
    </script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="includes/script.js"></script>
</body>

</html>