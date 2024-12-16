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


        // Buscando o usuário pelo email
        $usuario = $this->usuario->findByEmail($email);

        // Depuração: Exibindo os dados do usuário ou NULL


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
    public function atualizarUsuario(array $dados)
    {
        session_start();

        // Obter o ID do usuário logado
        $idUsuario = $_SESSION['usuario']->id ?? null;

        if (!$idUsuario) {
            $this->redirectWithMessage('index.php?c=usuario&a=logar', 'Você precisa estar logado para atualizar os dados.', 'warning');
            return;
        }

        // Validar os dados enviados
        $erros = $this->validarDadosUsuario($dados);
        if (!empty($erros)) {
            $mensagemErro = implode('<br>', $erros);
            $this->redirectWithMessage('index.php?c=usuario&a=atualizar', $mensagemErro, 'warning');
            return;
        }

        // Validar e-mail
        $email = filter_var($dados['email'], FILTER_VALIDATE_EMAIL);
        if (!$email) {
            $this->redirectWithMessage('index.php?c=usuario&a=atualizar', 'E-mail inválido.', 'warning');
            return;
        }

        // Atualizar os dados no model
        $this->usuario->data = (object) [
            'id' => $idUsuario,
            'nome' => $dados['nome'],
            'email' => $email,
            'telefone' => $dados['telefone'],
            'endereco' => $dados['endereco'],
            'cidade' => $dados['cidade'],
            'estado' => $dados['estado'],
            'cep' => $dados['cep'],
            'senha' => $_SESSION['usuario']->senha // Mantém a senha atual
        ];

        // Persistir os dados no banco
        if ($this->usuario->save()) {
            // Atualiza os dados na sessão
            $this->atualizarDadosSessao($this->usuario->data);

            $this->redirectWithMessage('index.php?c=usuario&a=atualizar', 'Dados atualizados com sucesso!', 'success');
        } else {
            $this->redirectWithMessage('index.php?c=usuario&a=atualizar', 'Erro ao atualizar os dados.', 'error');
        }
    }

    /**
     * Método para validar os dados do usuário.
     */
    private function validarDadosUsuario(array $dados): array
    {
        $erros = [];
        $camposObrigatorios = ['nome', 'email', 'telefone', 'endereco', 'cidade', 'estado', 'cep'];

        foreach ($camposObrigatorios as $campo) {
            if (empty($dados[$campo])) {
                $erros[] = "O campo $campo é obrigatório.";
            }
        }

        return $erros;
    }

    /**
     * Atualiza os dados do usuário na sessão.
     */
    private function atualizarDadosSessao(object $dadosUsuario): void
    {
        $_SESSION['usuario'] = $dadosUsuario;
    }



    public function main()
    {
        if (isset($_SESSION['usuario'])) {
            return "tema/admin/pages/main.php"; // Retorna o caminho do arquivo
        } else {
            header('location: index.php?c=usuario&a=logar');
            exit; // Certifique-se de chamar exit após o redirecionamento
        }
    }
}