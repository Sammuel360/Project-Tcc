<?php

require_once __DIR__ . '/vendor/autoload.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Source\Controllers\UsuarioController;
use Source\Controllers\ChamadoController;
use Source\Controllers\StatusController;
use Source\Controllers\NotificacaoController;
use Source\Controllers\OrgaoController;
use Source\Models\ChamadoModel;
use Source\Models\OrgaoModel;
use Source\Models\StatusModel;

session_start();

// Ajuste do filtro para sanitizar as entradas
$c = filter_input(INPUT_GET, 'c', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?: 'usuario'; // controller
$a = filter_input(INPUT_GET, 'a', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?: 'logar';   // action

// Verifica qual controller e action são chamados
switch ($c) {
    case 'usuario':
        $controller = new UsuarioController();
        switch ($a) {
            case 'logar':
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'], $_POST['password'])) {
                    $controller->autenticar($_POST['email'], $_POST['password']);
                } else {
                    include $controller->logar();
                }
                break;
            case 'main':
                $path = $controller->main(); // Chama o método e pega o caminho retornado
                if ($path) {
                    include $path; // Inclui o arquivo retornado
                }

                break;
            case 'cadastrar':
                include  $controller->cadastrar();
                break;
            case 'inserir':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $controller->registrarUsuario(
                        $_POST['nome'],
                        $_POST['email'],
                        $_POST['telefone'],
                        $_POST['senha'],
                        $_POST['endereco'],
                        $_POST['cidade'],
                        $_POST['estado'],
                        $_POST['cep']
                    );
                } else {
                    include $controller->cadastrar();
                }
                break;
            default:
                include $controller->logar(); // caso a action não seja reconhecida
                break;
        }
        break;

    case 'chamado':
        // Crie as instâncias dos modelos
        $statusModel = new StatusModel();
        $chamadoModel = new ChamadoModel();
        $orgaoModel = new OrgaoModel();

        // Crie a instância do StatusController passando o modelo de status
        $statusController = new StatusController($statusModel);

        // Crie a instância do ChamadoController passando todos os modelos e o StatusController
        $controller = new ChamadoController($chamadoModel, $orgaoModel, $statusModel, $statusController);



        switch ($a) {
            case 'abrirFormulario':
                $controller->abrirFormulario();
                break;
            case 'inserir':
                $controller->inserir();
                break;
            case 'detalhes':
                $chamadoId = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                if ($chamadoId) {
                    $controller->detalhes();
                } else {
                    header("Location: index.php?c=chamado&a=abrirFormulario");
                    exit;
                }
                break;

            default:
                header("Location: index.php?c=chamado&a=abrirFormulario");
                break;
        }
        break;

    case 'status':
        // Crie as instâncias dos modelos necessários
        $statusModel = new StatusModel();
        $chamadoModel = new ChamadoModel();
        $orgaoModel = new OrgaoModel();


        switch ($a) {
            case 'inserir':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $sanitizedData = filter_input_array(INPUT_POST, [
                        'chamado_id' => FILTER_SANITIZE_NUMBER_INT,
                        'status' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
                        'observacao' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
                    ]);

                    $validStatuses = ['pendente', 'em_progresso', 'concluido'];
                    if (!in_array($sanitizedData['status'], $validStatuses)) {
                        header("Location: index.php?c=status&a=listar&error=Status inválido.");
                        exit;
                    }

                    // Inserir o novo status no banco
                    header("Location: detalhesChamados.php?id=" . $sanitizedData['chamado_id']);
                    exit;
                }
                break;

            case 'listar':
                $chamadoId = filter_input(INPUT_GET, 'chamado_id', FILTER_SANITIZE_NUMBER_INT);
                if ($chamadoId) {
                    $statusController->listarPorChamado((int) $chamadoId);
                } else {
                    header("Location: detalhesChamados.php?error=ID do chamado inválido.");
                    exit;
                }
                break;

            case 'detalhes':
                $chamadoId = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_NUMBER_INT);
                if ($chamadoId) {
                    $statusController->detalhes((int) $chamadoId);
                } else {
                    header("Location: index.php?c=status&a=listar&error=ID do chamado é inválido.");
                    exit;
                }
                break;

            default:
                header("Location: index.php?c=status&a=listar");
                break;
        }
        break;


    case 'notificacao':
        $controller = new NotificacaoController();
        switch ($a) {
            case 'all':
                $controller->all();
                break;
            case 'enviar':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $controller->enviar($_POST['usuario_id'], $_POST['chamado_id'], $_POST['mensagem']);
                }
                break;
            case 'deletar':
                if (isset($_GET['id'])) {
                    $controller->deletar($_GET['id']);
                }
                break;
            default:
                $controller->all();
                break;
        }
        break;

    case 'orgao':
        $controller = new OrgaoController();
        switch ($a) {
            case 'listar':
                $orgaos = $controller->list();
                if ($orgaos) {
                    $_SESSION['orgaos'] = $orgaos;
                    include_once __DIR__ . '/tema/admin/pages/chamados.php';
                } else {
                    $_SESSION['message'] = 'Nenhum órgão encontrado!';
                    header("Location: index.php");
                }
                break;
            default:
                header("Location: index.php?c=orgao&a=listar");
                break;
        }
        break;

    case 'configuracoes':
        include_once __DIR__ . '/tema/admin/pages/configuracoes.php';
        break;

    case 'perfil':
        include_once __DIR__ . '/tema/admin/pages/perfil.php';
        break;

    case 'ajuda':
        include_once __DIR__ . '/tema/admin/pages/ajuda.php';
        break;

    default:
        $controller = new UsuarioController();
        include $controller->logar();
        break;
}
