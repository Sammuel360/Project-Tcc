<?php

namespace Source\Controllers;

use Source\Core\Model;
use Source\Models\UsuarioModel;

class Usuario extends Model
{
    private $usuarioModel;

    public function __construct()
    {
        $this->usuarioModel = new UsuarioModel();
        // Certifique-se de que as sessões estão iniciadas
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    public function logar()
    {
        include "app/views/logar.php"; // Corrigido para incluir a view
    }

    public function main()
    {
        if (isset($_SESSION['usuario'])) {
            include "app/views/tela1.php"; // Corrigido para incluir a view
        } else {
            $this->logar();
        }
    }

    public function cadastrar()
    {
        include "app/views/cadastroUsuario.php"; // Corrigido para incluir a view
    }

    public function autenticar(string $email, string $senha)
    {
        $usuario = $this->usuarioModel->findByEmail($email);

        if ($usuario) {
            // Comparação de senha simples sem hash
            if ($usuario->senha == $senha) {
                $_SESSION['usuario'] = $usuario;
                header("Location: index.php?c=usuario&a=main");
                exit;
            } else {
                header("Location: index.php?message=Falha na autenticacao");
                exit;
            }
        } else {
            header("Location: index.php?message=Acesso negado! Contate o administrador.");
            exit;
        }
    }

    public function all(): ?array
    {
        return $this->usuarioModel->all();
    }

    public function inserir(
        string $nome,
        string $email,
        string $telefone,
        string $endereco,
        string $cidade,
        string $estado,
        string $cep,
        string $senha
    ) {
        $this->usuarioModel->nome = $nome;
        $this->usuarioModel->email = $email;
        $this->usuarioModel->telefone = $telefone;
        $this->usuarioModel->endereco = $endereco;
        $this->usuarioModel->cidade = $cidade;
        $this->usuarioModel->estado = $estado;
        $this->usuarioModel->cep = $cep;

        // Senha sem hash
        $this->usuarioModel->senha = $senha;

        try {
            $this->usuarioModel->save();

            if ($this->usuarioModel->getMessage()) {
                header("Location: index.php?m={$this->usuarioModel->getMessage()}");
                exit;
            }
        } catch (\Exception $e) {
            // Melhor tratamento de erro
            header("Location: index.php?error=Erro ao salvar usuário. Tente novamente.");
            exit;
        }
    }
}