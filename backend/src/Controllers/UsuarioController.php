<?php

namespace backend\src\Controllers;

use backend\src\Models\UsuarioModel;

class UsuarioController
{
    private $usuario;

    public function __construct()
    {
        $this->usuario = new usuarioModel();
    }
    public function viewLogIn()
    {
        //Retorna para tela de login principal do site...
        return "tema/admin/pages/logar.php";
    }
    /**
     * A função foi criada com intuito de retornar a tela 
     * de registro do usuário
     * 
     * @return string O caminho da página de regitro
     */
    public function viewSignIn()
    {
        //Retorna para tela de registro do site...
        return "tema/admin/pages/cadastroUsuario.php";
    }
    /**
     * A função foi criada com intuito de retorna a tela 
     * principal
     * 
     * @return string O caminho da página principal caso tenha sessão, caso não retorna a tela de login
     */
    public function viewMain()
    {
        //Verifica se existe uma sessão ativa, caso tenha retorna
        //a tela principal
        if (isset($_SESSION['usuario'])) {
            return "tema/admin/pages/dashboard.php";
        }
        //retorna o caminho da tela principal
        //Caminho da tela de login
        return $this->viewLogIn();
    }
    /**
     * A função foi criada com o intuito de autenticar os dados 
     * inseridos pelo usuário para dar acesso ao sistema (logar).
     * 
     * @return mixed O caminho do arquivo de controle de fluxo
     * de dados e salva as informações em uma sessão, caso os 
     * dados não tenham sido inseridos corretamente , retorna 
     * ao controle de dados com uma mensagem de falha.
     */
    public function autenticar(string $email, string $senha)
    {
        //Busca o email inserido e retorna o objeto Usuário que tem
        //aquele email inserido
        $usuario = $this->usuario->findByEmail($email);

        //Verifica se encontrou algum usuário com o email inserido,
        //caso não encontre, retorna para a tela principal e uma 
        //mensagem na url.
        if ($usuario) {
            //Verifica se a senha inserida, corresponde com a senha 
            //do usuário 
            if ($usuario->senha == $senha) {

                //Cria um seção com o objetivo de dar persistência a 
                //esses dados e armazenar as informações do objeto 
                //usuário 
                $_SESSION['usuario'] = $usuario;

                //Retorna ao controle de fluxo de dados so sistema
                header('location: index.php?c=usuario&a=main');
            } else {
                header("location: index.php?message=Email ou senha incorretos&typeMessage=warning");
            }
        } else {
            //Retorna para o controle de fluxo de dados e leva a mensagem na url
            header("location: index.php?message=Falha na autenticacao&typeMessage={$this->usuario->getTypeMessage()}");
        }
    }

    public function inserir(string $nome, string $email, string $telefone, string $senha, string $endereco, string $cidade, string $estado, string $cep)
    {
     // Criptografando a senha
     $senha = password_hash($senha, PASSWORD_DEFAULT);

        //Salvar no banco de dados os valores recebidos
        $this->usuario->nome = $nome;
        $this->usuario->email = $email;
        $this->usuario->telefone = $telefone;
        $this->usuario->endereco = $endereco;
        $this->usuario->cidade = $cidade;
        $this->usuario->estado = $estado;
        $this->usuario->cep = $cep;
        $this->usuario->senha = $senha;
        $this->usuario->save();

        //Verifica se houve uma falha ou se teve algum tipo de 
        //erro de inserção dos valores da parte do usuário
        if ($this->usuario->getFail()) {
            echo "Falha ao cadastrar";
        } else {
            //Verifica se o usuário conseguiu se cadastrar com sucesso ,
            //caso tenha conseguido ele retorna a tela de login ,
            //caso não ele retorna a tela de cadastro com a falha.
            if ($this->usuario->getTypeMessage() === "sucess") {
                //Retorna a mensagem de sucesso e o tipo da mensagem
                header("location: index.php?message={$this->usuario->getMessage()}&typeMessage={$this->usuario->getTypeMessage()}");
            } else {
                //Retorna a mensagem de falha e o tipo da mensagem
                header("location: index.php?c=usuario&a=registro&message={$this->usuario->getMessage()}&typeMessage={$this->usuario->getTypeMessage()}");
            }
        }
        return true;
    }
}
