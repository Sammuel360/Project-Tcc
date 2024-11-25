<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

use Source\Controllers\UsuarioController;
use Source\Controllers\ChamadoController;
use Source\Controllers\StatusController;
use Source\Controllers\NotificacaoController;

session_start();
require_once __DIR__ . '/vendor/autoload.php';

require_once 'vendor/autoload.php';

// Ajuste do filtro para sanitizar as entradas
$c = filter_input(INPUT_GET, 'c', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?: 'usuario'; // controller
$a = filter_input(INPUT_GET, 'a', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?: 'logar';   // action

switch ($c) {
    case 'usuario':
        $controller = new UsuarioController();
        switch ($a) {
            case 'logar':
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'], $_POST['password'])) {
                    $controller->autenticar($_POST['email'], $_POST['password']);
                } else {
                    $controller->logar();
                }
                break;
            case 'main':
                $controller->main();
                break;
            case 'cadastrar':
                $controller->cadastrar();
                break;
            case 'inserir':
                if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                    $controller->inserir($_POST);
                } else {
                    $controller->cadastrar();
                }
                break;
        }
        break;

    case 'chamado':
        $controller = new ChamadoController();
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
        }
        break;

    case 'status':
        $controller = new StatusController();
        $controller->index();
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

    default:
        $controller = new UsuarioController();
        $controller->logar();
        break;
}
