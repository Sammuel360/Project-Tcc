<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abrir Chamado</title>



    <style>
    /* Estilo do formulário */
    body {
        font-family: Arial, sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f9f9f9;
    }

    .container {
        max-width: 800px;
        margin: 20px auto;
        background: #fff;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }

    label {
        display: block;
        margin-bottom: 8px;
        font-weight: bold;
    }

    input,
    textarea,
    select {
        width: 100%;
        padding: 10px;
        margin-bottom: 15px;
        border: 1px solid #ddd;
        border-radius: 4px;
    }
    </style>
</head>

<body>
    <?php include_once __DIR__ . '/../includes/menulateral.php'; ?>

    <div class="container">
        <h1>Abrir Chamado</h1>

        <?php if (!empty($_SESSION['message'])): ?>
        <div class="alert">
            <?= $_SESSION['message']; ?>
            <?php unset($_SESSION['message']); ?>
        </div>
        <?php endif; ?>

        <form action="index.php?c=chamado&a=inserir" method="POST">
            <label for="titulo">Título:</label>
            <input type="text" name="titulo" id="titulo" required>

            <label for="descricao">Descrição:</label>
            <textarea name="descricao" id="descricao" required></textarea>

            <label for="cep">CEP:</label>
            <input type="text" name="cep" id="cep" required>

            <label for="endereco">Endereço:</label>
            <input type="text" name="endereco" id="endereco" required>

            <label for="orgao_id">Órgão Responsável:</label>
            <select name="orgao_id" id="orgao_id">
                <option value="">Selecione o órgão</option>
                <?php
                // Verifica se os dados de órgãos estão na sessão
                if (isset($_SESSION['orgaos']) && !empty($_SESSION['orgaos'])):
                    // Recupera os órgãos da sessão
                    $orgaos = $_SESSION['orgaos'];
                    foreach ($orgaos as $orgao):
                ?>
                <option value="<?= $orgao['id'] ?>"><?= htmlspecialchars($orgao['nome']) ?></option>
                <?php
                    endforeach;
                endif;
                ?>
            </select>




            <button type="submit" class="button">Abrir Chamado</button>
        </form>


    </div>



</body>

</html>