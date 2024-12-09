<?php

namespace Source\Controllers;

use Source\Models\UsuarioModel;

class UsuarioController
{
    private $usuario;

    public function __construct()
    {
        $this->usuario = new UsuarioModel();
    }

    private function redirectWithMessage($location, $message, $type)
    {
        header("location: $location?message=$message&typeMessage=$type");
        exit;
    }

    public function logar()
    {
        return "tema/admin/pages/logar.php";
    }

    public function cadastrar()
    {
        return "tema/admin/pages/cadastroUsuario.php";
    }

    public function viewMain()
    {
        if (isset($_SESSION['usuario'])) {
            return "tema/admin/pages/main.php";
        }
        return $this->logar();
    }
    public function autenticar(string $email, string $senha)
    {
        session_start(); // Começando a sessão

        // Validando e sanitizando o e-mail
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        if (!$email) {
            $this->redirectWithMessage('index.php', 'E-mail inválido', 'warning');
        }

        // Depuração: Exibindo o e-mail antes da consulta
        var_dump($email); // Verifica se o e-mail está correto

        // Buscando o usuário pelo email
        $usuario = $this->usuario->findByEmail($email);

        // Depuração: Exibindo os dados do usuário ou NULL
        var_dump($usuario); // Verifica se o usuário foi encontrado no banco de dados

        // Verificando se o usuário foi encontrado e se a senha está correta
        if (!$usuario) {
            $this->redirectWithMessage('index.php', 'E-mail não encontrado', 'warning');
        }

        if (!password_verify($senha, $usuario->senha)) {
            $this->redirectWithMessage('index.php', 'Senha incorreta', 'warning');
        }

        // Se o usuário for encontrado e a senha for válida
        $_SESSION['usuario'] = $usuario;
        header('location: index.php?c=usuario&a=main');
        exit;
    }


    public function registrarUsuario(string $nome, string $email, string $telefone, string $senha, string $endereco, string $cidade, string $estado, string $cep)
    {
        // Verificando se todos os campos estão preenchidos
        if (empty($nome) || empty($email) || empty($telefone) || empty($senha) || empty($endereco) || empty($cidade) || empty($estado) || empty($cep)) {
            $this->redirectWithMessage('index.php', 'Preencha todos os campos', 'warning');
        }

        // Validando o e-mail
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
        if (!$email) {
            $this->redirectWithMessage('index.php', 'E-mail inválido', 'warning');
        }

        // Criptografando a senha
        $senha = password_hash($senha, PASSWORD_DEFAULT);

        // Preenchendo as propriedades do usuário
        $this->usuario->nome = $nome;
        $this->usuario->email = $email;
        $this->usuario->telefone = $telefone;
        $this->usuario->endereco = $endereco;
        $this->usuario->cidade = $cidade;
        $this->usuario->estado = $estado;
        $this->usuario->cep = $cep;
        $this->usuario->senha = $senha;

        // Salvando no banco de dados
        $this->usuario->save();

        // Verificando falhas e redirecionando com mensagens
        if ($this->usuario->getFail()) {
            $this->redirectWithMessage('index.php', 'Falha ao cadastrar', 'error');
        } else {
            $this->redirectWithMessage('index.php', 'Cadastro realizado com sucesso', 'success');
        }

        return true;
    }

    public function main()
    {
        if (isset($_SESSION['usuario'])) {
            var_dump($_SESSION['usuario']);
            include "tema/admin/pages/main.php";
        } else {
            header('location: index.php?c=usuario&a=logar');
        }
    }
}
