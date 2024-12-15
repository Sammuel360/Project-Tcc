// listaStatus.php
<?php if (isset($_SESSION['mensagem_erro'])): ?>
<div class="alert alert-danger"><?php echo $_SESSION['mensagem_erro'];
                                    unset($_SESSION['mensagem_erro']); ?></div>
<?php endif; ?>

<h2>Lista de Chamados</h2>
<table>
    <thead>
        <tr>
            <th>Título</th>
            <th>Órgão</th>
            <th>Status</th>
            <th>Histórico de Status</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($chamados as $chamado): ?>
        <tr>
            <td><?php echo $chamado->titulo; ?></td>
            <td><?php echo $chamado->nome_orgao; ?></td>
            <td><?php echo $chamado->status; ?></td>
            <td>
                <ul>
                    <?php foreach ($chamado->historicoStatus as $status): ?>
                    <li><?php echo $status->status; ?> - <?php echo $status->data_alteracao; ?> -
                        <?php echo $status->observacao; ?></li>
                    <?php endforeach; ?>
                </ul>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>