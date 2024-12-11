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
use Source\Models\ChamadoModel; // Adicione essa linha
use Source\Models\OrgaoModel; // Adicione essa linha

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
                include $controller->main();

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
        $chamadoModel = new ChamadoModel(); // Crie a instância do ChamadoModel
        $orgaoModel = new OrgaoModel(); // Crie a instância do OrgaoModel
        $controller = new ChamadoController($chamadoModel, $orgaoModel); // Passe as instâncias ao ChamadoController
        switch ($a) {
            case 'abrirFormulario':
                $controller->abrirFormulario();
                break;
            case 'inserir':
                $controller->inserir();
                break;
            case 'detalhes':
                $controller->detalhes();
                break;
            default:
                header("Location: index.php?c=chamado&a=abrirFormulario");
                break;
        }
        break;

    case 'status':
        $controller = new StatusController();
        switch ($a) {
            case 'inserir':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $sanitizedData = filter_input_array(INPUT_POST, [
                        'chamado_id' => FILTER_SANITIZE_NUMBER_INT,
                        'status' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
                        'observacao' => FILTER_SANITIZE_FULL_SPECIAL_CHARS,
                    ]);
                    $controller->inserir($sanitizedData);
                }
                break;
            case 'listar':
                $chamadoId = filter_input(INPUT_GET, 'chamado_id', FILTER_SANITIZE_NUMBER_INT);
                if ($chamadoId) {
                    $controller->listarPorChamado((int) $chamadoId);
                } else {
                    header("Location: detalhesChamados.php?error=ID do chamado inválido.");
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
                // Obtém os órgãos com o método correto
                $orgaos = $controller->list();  // Agora usando o método 'listar' (similar ao 'listarTodos')

                if ($orgaos) {
                    // Passa os dados para a página
                    $_SESSION['orgaos'] = $orgaos;  // Armazena os órgãos na sessão
                    include_once __DIR__ . '/tema/admin/pages/chamados.php';  // Inclui a página de chamados
                } else {
                    // Se não houver órgãos, redireciona com mensagem de erro
                    $_SESSION['message'] = 'Nenhum órgão encontrado!';
                    header("Location: index.php");
                }
                break;

            default:
                // Ação padrão para listar órgãos
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
