<?php

session_start();

use Source\Controllers\Usuario; // Corrigido o namespace para "Controllers"

require_once 'vendor/autoload.php';

$c = 'web';

if (isset($_GET['c']) && isset($_GET['a'])) {
    $c = filter_var($_GET['c'], FILTER_SANITIZE_STRING); // controller
    $a = filter_var($_GET['a'], FILTER_SANITIZE_STRING); // action 
}

/**
 * Gerencia as rotas da aplicação
 */

switch ($c) {
    case 'usuario':
        switch ($a) {
            case 'logar':
                $controller = new Usuario();
                $controller->autenticar($_POST['email'], $_POST['password']);
                break;
            case 'main':
                $controller = new Usuario();
                $controller->main(); // Retirada a inclusão errada
                break;
            case 'cadastrar':
                $controller = new Usuario();
                $controller->cadastrar(); // Retirada a inclusão errada
                break;
            case 'inserir':
                $controller = new Usuario();
                $controller->inserir(
                    $_POST['nome'],
                    $_POST['email'],
                    $_POST['telefone'],
                    $_POST['endereco'],
                    $_POST['cidade'],
                    $_POST['estado'],
                    $_POST['cep'],
                    $_POST['senha']
                );
                break;
            default:
                $controller = new Usuario();
                $controller->logar();
                break;
        }
        break;

    default:
        // Rota padrão, por exemplo, pode ser redirecionada para login ou página principal
        $controller = new Usuario();
        $controller->logar();
        break;
}
