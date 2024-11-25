<!DOCTYPE html>
<html lang="pt-BR">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resumo de Chamados</title>
    <link rel="stylesheet" href="style.css">
    <style>
        /* style.css */
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            padding: 20px;
            background-color: #f8f9fa;
        }

        .dashboard-container {
            display: flex;
            gap: 20px;
        }

        .chart,
        .summary {
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .chart {
            width: 250px;
            text-align: center;
        }

        .chart h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        .donut-chart {
            position: relative;
            width: 120px;
            height: 120px;
            margin: 0 auto;
        }

        .percentage {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-size: 24px;
            font-weight: bold;
        }

        svg {
            width: 100%;
            height: 100%;
            transform: rotate(-90deg);
        }

        .circle-bg {
            fill: none;
            stroke: #fbc3c3;
            stroke-width: 4;
        }

        .circle {
            fill: none;
            stroke: #4dd0e1;
            stroke-width: 4;
            stroke-dasharray: 75 100;
            stroke-linecap: round;
        }

        .legend {
            display: flex;
            justify-content: center;
            margin-top: 10px;
        }

        .legend span {
            display: flex;
            align-items: center;
            margin: 0 10px;
            font-size: 14px;
        }

        .legend-color {
            width: 12px;
            height: 12px;
            display: inline-block;
            margin-right: 5px;
        }

        .no-result {
            background-color: #fbc3c3;
        }

        .problem {
            background-color: #4dd0e1;
        }

        .summary {
            flex: 1;
        }

        .summary h3 {
            font-size: 18px;
            margin-bottom: 10px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table th,
        table td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        table th {
            color: #555;
            font-weight: normal;
            font-size: 14px;
        }

        table td {
            font-size: 14px;
            color: #333;
        }
    </style>
</head>

<body>
    <div class="dashboard-container">
        <div class="chart">
            <h3>Chamados abertos por prioridade</h3>
            <div class="donut-chart">
                <div class="percentage">75%</div>
                <svg viewBox="0 0 32 32">
                    <circle class="circle-bg" cx="16" cy="16" r="14"></circle>
                    <circle class="circle" cx="16" cy="16" r="14"></circle>
                </svg>
            </div>
            <div class="legend">
                <span><span class="legend-color no-result"></span> Nenhum resultado</span>
                <span><span class="legend-color problem"></span> Problema</span>
            </div>
        </div>

        <div class="summary">
            <h3>Resumo de chamados</h3>
            <table>
                <thead>
                    <tr>
                        <th>Título</th>
                        <th>Categoria</th>
                        <th>Vencimento</th>
                        <th>Criado em</th>
                        <th>Fase atual</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Instalação de novo software</td>
                        <td></td>
                        <td></td>
                        <td>10 de nov. de 2024</td>
                        <td>Concluído</td>
                    </tr>
                    <tr>
                        <td>Internet instável</td>
                        <td>Problema</td>
                        <td></td>
                        <td>10 de nov. de 2024</td>
                        <td>Triagem</td>
                    </tr>
                    <tr>
                        <td>Notebook está muito lento e travando frequentemente</td>
                        <td></td>
                        <td></td>
                        <td>10 de nov. de 2024</td>
                        <td>Escalar o problema</td>
                    </tr>
                    <tr>
                        <td>Renovação de licenças do Office</td>
                        <td></td>
                        <td></td>
                        <td>10 de nov. de 2024</td>
                        <td>Arquivado</td>
                    </tr>
                    <tr>
                        <td>Teclado não funciona</td>
                        <td></td>
                        <td></td>
                        <td>10 de nov. de 2024</td>
                        <td>Em atendimento</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>