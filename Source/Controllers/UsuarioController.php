<?php

namespace Source\Controllers;

use Source\Models\UsuarioModel;

class UsuarioController
{
    private $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
    }

    // UsuarioController.php

    public function autenticar(string $email, string $password)
    {
        // Sanitizando o email
        $email = filter_var($email, FILTER_SANITIZE_EMAIL);

        $usuario = $this->usuarioModel->findByEmail($email);

        if ($usuario && password_verify($password, $usuario->senha)) {
            // Inicia a sessão e armazena o usuário logado
            $_SESSION['usuario'] = $usuario;

            // Redireciona para a tela principal (Dashboard) após o login
            header("Location: /cidadaofisca/tema/admin/main.php");
            exit;
        }

        // Mensagem de erro no login
        $_SESSION['message'] = 'Email ou senha incorretos';
        header("Location: /index.php?c=usuario&a=logar");  // Redireciona de volta para a página de login
        exit;
    }


    public function inserir(array $data)
    {
        try {
            // Sanitizando os dados de entrada
            $nome = filter_var($data['nome'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_var($data['email'], FILTER_SANITIZE_EMAIL);
            $telefone = filter_var($data['telefone'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $endereco = filter_var($data['endereco'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $cidade = filter_var($data['cidade'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $estado = filter_var($data['estado'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $cep = filter_var($data['cep'], FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $senha = $data['senha'];

            // Validação de dados
            if (empty($nome) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($senha)) {
                header("Location: index.php?error=Dados inválidos.");
                exit;
            }

            // Verificação de e-mail duplicado
            if ($this->usuarioModel->findByEmail($email)) {
                header("Location: index.php?error=E-mail já cadastrado.");
                exit;
            }

            // Criptografando a senha
            $senha = password_hash($senha, PASSWORD_DEFAULT);

            // Salvando o usuário
            if (!$this->usuarioModel->save([
                'nome' => $nome,
                'email' => $email,
                'telefone' => $telefone,
                'endereco' => $endereco,
                'cidade' => $cidade,
                'estado' => $estado,
                'cep' => $cep,
                'senha' => $senha
            ])) {
                header("Location: index.php?message={$this->usuarioModel->getMessage()}");
                exit;
            }
            header("Location: index.php?message=Usuário cadastrado com sucesso");
            exit;
        } catch (\Exception $e) {
            header("Location: index.php?error=Erro ao salvar usuário. Tente novamente.");
            exit;
        }
    }

    public function logar()
    {
        // Página de login
        require 'tema/admin/logar.php';
    }

    public function main()
    {
        // Verifica se o usuário está logado antes de permitir o acesso à página principal
        if (!isset($_SESSION['usuario'])) {
            header('Location: /index.php?c=usuario&a=logar');
            exit;
        }

        // Página principal após o login
        require 'tema/admin/main.php';  // Correção do caminho
    }

    public function cadastrar()
    {
        // Página de cadastro
        require 'tema/admin/cadastroUsuario.php';  // Correção do caminho
    }
}