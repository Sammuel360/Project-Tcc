<?php include_once __DIR__ . '/../includes/menulateral.php'; ?>
<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header("Location: index.php?c=usuario&a=logar");
    exit;
}

$usuario = $_SESSION['usuario'];
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Configurações - Fiscal Cidadão</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
    <style>
        body {
            background-color: #f4f7f9;
            font-family: 'Roboto', sans-serif;
        }

        /* Barra Superior */
        header .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 2rem;
            background-color: #0066cc;
            color: white;
            position: fixed;
            top: 0;
            width: 100%;
            z-index: 1000;
        }

        header .top-bar h1 {
            font-size: 1.8rem;
            font-weight: bold;
        }

        header .top-bar nav a {
            color: white;
            text-decoration: none;
            margin: 0 1.5rem;
            font-size: 1rem;
        }

        header .top-bar .profile-section {
            display: flex;
            align-items: center;
        }

        header .top-bar .profile-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            margin-right: 0.5rem;
        }

        .dashboard-header {
            margin: 20px 0;
            color: #333;
        }
    </style>
</head>

<body>


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
                        <div class="form-group">
                            <label for="telefone">Telefone</label>
                            <input type="text" class="form-control" id="telefone" name="telefone"
                                value="(99) 99999-9999">
                        </div>
                        <div class="form-group">
                            <label for="endereco">Endereço</label>
                            <input type="text" class="form-control" id="endereco" name="endereco"
                                value="Rua Exemplo, 123">
                        </div>
                        <div class="form-group">
                            <label for="cidade">Cidade</label>
                            <input type="text" class="form-control" id="cidade" name="cidade" value="São Paulo">
                        </div>
                        <div class="form-group">
                            <label for="estado">Estado</label>
                            <input type="text" class="form-control" id="estado" name="estado" value="SP">
                        </div>
                        <div class="form-group">
                            <label for="cep">CEP</label>
                            <input type="text" class="form-control" id="cep" name="cep" value="12345-678">
                        </div>
                        <button type="submit" class="btn btn-primary">Salvar Alterações</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>

    </script>
</body>

</html>