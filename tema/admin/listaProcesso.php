<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Departamentos</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f0f0f0;
        }

        .container {
            width: 80%;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th,
        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #dddddd;
        }

        th {
            background-color: #f2f2f2;
            color: #333333;
            font-weight: bold;
            text-transform: uppercase;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f2f2f2;
        }

        @media only screen and (max-width: 768px) {
            .container {
                width: 100%;
                border-radius: 0;
            }
        }
    </style>
</head>

<body>

    <div class="container">
        <h2>Processos</h2>
        <table>
            <tr>
                <th>ID</th>
                <th>Tipo de Processo</th>
                <th>Nome do Processo</th>
                <th>Prioridade</th>
                <th>Responsavel</th>
                <th>Preazo</th>
                <th>Data Abertura</th>
            </tr>            

            <?php if (is_array($processos) ): ?>
                <?php foreach ($processos as $processo): ?>
                    <tr>
                        <td><?= $processo->idprocesso ?></td>
                        <td><?= $processo->tipoProcesso ?></td>
                        <td><?= $processo->nome ?></td>
                        <td><?= $processo->prioridade ?></td>
                        <td><?= $processo->responsavel ?></td>
                        <td><?= $processo->prazo ?></td>
                        <td><?= $processo->data_abertura ?></td>


                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </table>

    </div>

</body>

</html>
