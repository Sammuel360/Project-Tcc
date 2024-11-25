<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Abrir Chamado</title>
    <link rel="stylesheet" href="styles.css"> <!-- Adicione o caminho correto para seu CSS -->
    <style>
        /* Estilo geral */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
            line-height: 1.6;
        }

        /* Cabeçalho */
        h1 {
            text-align: center;
            margin: 20px 0;
            color: #444;
        }

        /* Container principal */
        .container {
            max-width: 800px;
            margin: 20px auto;
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }

        /* Estilo dos campos */
        label {
            display: block;
            margin: 10px 0;
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
            font-size: 16px;
        }

        /* Estilo do botão */
        .button {
            display: inline-block;
            margin: 20px 0;
            padding: 10px 20px;
            font-size: 16px;
            font-weight: bold;
            text-decoration: none;
            background: #007bff;
            color: #fff;
            border-radius: 5px;
            text-align: center;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        .button:hover {
            background: #0056b3;
        }

        /* Layout responsivo */
        @media (max-width: 600px) {
            .container {
                padding: 15px;
            }

            label {
                font-size: 14px;
            }

            input,
            textarea,
            select {
                font-size: 14px;
            }

            .button {
                font-size: 14px;
                padding: 8px 16px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Abrir Novo Chamado</h1>

        <?php if (!empty($_SESSION['message'])): ?>
            <div class="alert">
                <?= $_SESSION['message']; ?>
                <?php unset($_SESSION['message']); ?>
            </div>
        <?php endif; ?>

        <form action="index.php?c=chamado&a=inserir" method="POST">
            <div class="form-group">
                <label for="titulo">Título <span class="required">*</span></label>
                <input type="text" id="titulo" name="titulo" placeholder="Informe o título do chamado" required>
            </div>

            <div class="form-group">
                <label for="descricao">Descrição <span class="required">*</span></label>
                <textarea id="descricao" name="descricao" rows="4" placeholder="Descreva o problema"
                    required></textarea>
            </div>

            <div class="form-group">
                <label for="cep">CEP <span class="required">*</span></label>
                <input type="text" id="cep" name="cep" placeholder="Ex: 12345-678" required>
            </div>

            <div class="form-group">
                <label for="endereco">Endereço <span class="required">*</span></label>
                <input type="text" id="endereco" name="endereco" placeholder="Informe o endereço completo" required>
            </div>

            <div class="form-group">
                <label for="orgao_id">Órgão Competente</label>
                <select id="orgao_id" name="orgao_id">
                    <option value="">Selecione um órgão</option>
                    <?php foreach ($orgaos as $orgao): ?>
                        <option value="<?= $orgao->id; ?>"><?= $orgao->nome; ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <input type="hidden" name="usuario_id" value="1"> <!-- Ajuste para capturar o ID do usuário logado -->

            <div class="form-group">
                <button type="submit">Abrir Chamado</button>
            </div>
        </form>
    </div>
</body>

</html>