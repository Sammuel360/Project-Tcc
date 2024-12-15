<?php
// Verifica se os dados do chamado e do status estão disponíveis
$chamadoId = $_GET['id'] ?? null;
$statusList = $_SESSION['statusList'] ?? [];
?>

<h1>Detalhes do Chamado #<?= htmlspecialchars($chamadoId) ?></h1>

<!-- Exibe o histórico de status -->
<h2>Histórico de Status</h2>
<table border="1">
    <thead>
        <tr>
            <th>Status</th>
            <th>Data de Alteração</th>
            <th>Observação</th>
        </tr>
    </thead>
    <tbody>
        <?php if (!empty($statusList)): ?>
        <?php foreach ($statusList as $status): ?>
        <tr>
            <td><?= htmlspecialchars($status->status) ?></td>
            <td><?= htmlspecialchars($status->data_alteracao) ?></td>
            <td><?= htmlspecialchars($status->observacao) ?></td>
        </tr>
        <?php endforeach; ?>
        <?php else: ?>
        <tr>
            <td colspan="3">Nenhum histórico disponível.</td>
        </tr>
        <?php endif; ?>
    </tbody>
</table>