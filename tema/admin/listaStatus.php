<?php if (isset($_SESSION['mensagem_erro'])): ?>
<div class="alert alert-danger"><?php echo $_SESSION['mensagem_erro'];
                                    unset($_SESSION['mensagem_erro']); ?></div>
<?php endif; ?>

<style>
/* Container para os cartões */
.status-cards {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    margin-top: 20px;
}

/* Estilo do cartão de chamado */
.status-card {
    width: 100%;
    max-width: 400px;
    border: 1px solid #e0e0e0;
    border-radius: 8px;
    background-color: #ffffff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    overflow: hidden;
    transition: all 0.3s ease-in-out;
}

/* Efeito ao passar o mouse sobre o cartão */
.status-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
}

/* Cabeçalho do cartão */
.card-header {
    background-color: #f5f5f5;
    padding: 15px;
    border-bottom: 1px solid #e0e0e0;
}

.card-header h3 {
    margin: 0;
    font-size: 18px;
    color: #333;
}

.card-header .orgao {
    font-size: 14px;
    color: #777;
}

/* Corpo do cartão */
.card-body {
    padding: 15px;
}

/* Estilo do status */
.status {
    margin-bottom: 10px;
}

.status-label {
    font-weight: bold;
    color: #333;
}

.status-value {
    padding: 5px 10px;
    border-radius: 4px;
    font-weight: bold;
}

.status-value.pendente {
    background-color: #ffcc00;
    color: #fff;
}

.status-value.em_progresso {
    background-color: #00aaff;
    color: #fff;
}

.status-value.concluido {
    background-color: #28a745;
    color: #fff;
}

/* Histórico de status */
.historico {
    margin-top: 20px;
}

.historico h4 {
    font-size: 16px;
    color: #333;
    margin-bottom: 10px;
}

.historico-item {
    border-bottom: 1px solid #f0f0f0;
    padding-bottom: 10px;
    margin-bottom: 10px;
}

.historico-item:last-child {
    border-bottom: none;
}

.historico-status {
    font-weight: bold;
    color: #333;
}

.historico-data {
    font-size: 12px;
    color: #888;
    margin-left: 10px;
}

.historico-observacao {
    font-size: 14px;
    color: #555;
    margin-top: 5px;
}
</style>
<h2>Lista de Chamados</h2>

<div class="status-cards">
    <?php foreach ($chamados as $chamado): ?>
    <div class="status-card">
        <div class="card-header">
            <h3><?php echo htmlspecialchars($chamado->titulo); ?></h3>
            <p class="orgao">Órgão: <?php echo htmlspecialchars($chamado->nome_orgao); ?></p>
        </div>

        <div class="card-body">
            <div class="status">
                <span class="status-label">Status Atual:</span>
                <span
                    class="status-value <?php echo strtolower($chamado->status); ?>"><?php echo htmlspecialchars($chamado->status); ?></span>
            </div>

            <div class="historico">
                <h4>Histórico de Status:</h4>
                <ul>
                    <?php foreach ($chamado->historicoStatus as $status): ?>
                    <li class="historico-item">
                        <span class="historico-status"><?php echo htmlspecialchars($status->status); ?></span>
                        <span class="historico-data"><?php echo htmlspecialchars($status->data_alteracao); ?></span>
                        <p class="historico-observacao"><?php echo htmlspecialchars($status->observacao); ?></p>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>