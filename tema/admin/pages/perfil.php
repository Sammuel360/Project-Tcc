<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurações - Fiscal Cidadão</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="includes/menulateral.css"> <!-- CSS separado -->
</head>

<body>


    <!-- Incluir o menu lateral -->
    <?php include_once __DIR__ . '/includes/menulateral.php'; ?>

    <div id="content">
        <div class="container-fluid">
            <div class="dashboard-header text-center">
                <h1>Configurações - Fiscal Cidadão</h1>
                <p>Atualize suas informações pessoais e de contato</p>
            </div>

            <div class="card">
                <div class="card-header">Configurações de Perfil</div>
                <div class="card-body">
                    <form action="update_usuario.php" method="POST">
                        <!-- Campos do formulário -->
                        <div class="form-group">
                            <label for="nome">Nome Completo</label>
                            <input type="text" class="form-control" id="nome" name="nome" value="Nome do Usuário"
                                required>
                        </div>
                        <div class="form-group">
                            <label for="email">E-mail</label>
                            <input type="email" class="form-control" id="email" name="email" value="usuario@example.com"
                                required>
                        </div>
                        <!-- Outros campos -->
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="includes/script.js"></script> <!-- JS separado -->
</body>

</html>